<?php

namespace App\UseCases\UserUseCases\CreateUserUseCase;

use App\Domain\Interfaces\DepartmentInterfaces\DepartmentRepository;
use App\Domain\Interfaces\UserInterfaces\UserFactory;
use App\Domain\Interfaces\UserInterfaces\UserRepository;
use App\Domain\Interfaces\ViewModel;

class CreateUserInteractor implements CreateUserInputPort
{
    /**
     * @param  CreateUserOutputPort  $output
     * @param  UserRepository  $userRepository
     * @param  DepartmentRepository  $departmentRepository
     * @param  UserFactory  $userFactory
     */
    public function __construct(
        private readonly CreateUserOutputPort $output,
        private readonly UserRepository $userRepository,
        private readonly DepartmentRepository $departmentRepository,
        private readonly UserFactory $userFactory
    ) {
    }

    /**
     * @param  CreateUserRequestModel  $request
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function createUser(CreateUserRequestModel $request): ViewModel
    {
        $user = $this->userFactory->makeFromCreateRequest($request);

        // Check user exists
        if ($this->userRepository->exists($user)) {
            return $this->output->userAlreadyExists(
                App()->makeWith(CreateUserResponseModel::class, ['user' => $user])
            );
        }

        // Try to get department
        try {
            $department = $this->departmentRepository->getById($user->getDepartmentId());
        } catch (\Exception $e) {
            return $this->output->noSuchDepartment(
                App()->makeWith(CreateUserResponseModel::class, ['user' => $user])
            );
        }

        // Try to create
        try {
            $user = $this->userRepository->create($user);

            $user = $user->fresh([]);
        } catch (\Exception $e) {
            return $this->output->unableToCreateUser(
                App()->makeWith(CreateUserResponseModel::class, ['user' => $user]),
                $e
            );
        }

        return $this->output->userCreated(
            App()->makeWith(CreateUserResponseModel::class, ['user' => $user])
        );
    }
}
