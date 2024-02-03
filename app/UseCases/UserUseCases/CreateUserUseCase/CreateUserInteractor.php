<?php

namespace App\UseCases\UserUseCases\CreateUserUseCase;

use App\Domain\Interfaces\DepartmentInterfaces\DepartmentFactory;
use App\Domain\Interfaces\DepartmentInterfaces\DepartmentRepository;
use App\Domain\Interfaces\UserInterfaces\UserFactory;
use App\Domain\Interfaces\UserInterfaces\UserRepository;
use App\Domain\Interfaces\ViewModel;

class CreateUserInteractor implements CreateUserInputPort
{
    public function __construct(
        private readonly CreateUserOutputPort $output,
        private readonly UserRepository $userRepository,
        private readonly DepartmentRepository $departmentRepository,
        private readonly DepartmentFactory $departmentFactory,
        private readonly UserFactory $userFactory,
    ) {
    }

    public function createUser(CreateUserRequestModel $request): ViewModel
    {
        $user = $this->userFactory->makeFromCreateRequest($request);

        if ($this->userRepository->exists($user)) {
            return $this->output->userAlreadyExists(
                App()->makeWith(CreateUserResponseModel::class, ['user' => $user])
            );
        }

        $department = $this->departmentFactory->makeFromId($user->getDepartmentId());

        try {
            $department = $this->departmentRepository->getById($department->getId());
        } catch (\Exception $e) {
            return $this->output->noSuchDepartment(
                App()->makeWith(CreateUserResponseModel::class, ['user' => $user])
            );
        }

        try {
            $user = $this->userRepository->create($user);
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
