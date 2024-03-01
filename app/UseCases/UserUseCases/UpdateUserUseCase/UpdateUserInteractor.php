<?php

namespace App\UseCases\UserUseCases\UpdateUserUseCase;

use App\Domain\Interfaces\DepartmentInterfaces\DepartmentRepository;
use App\Domain\Interfaces\UserInterfaces\UserFactory;
use App\Domain\Interfaces\UserInterfaces\UserRepository;
use App\Domain\Interfaces\ViewModel;

class UpdateUserInteractor implements UpdateUserInputPort
{
    /**
     * @param  UpdateUserOutputPort  $output
     * @param  UserRepository  $userRepository
     * @param  DepartmentRepository  $departmentRepository
     * @param  UserFactory  $userFactory
     */
    public function __construct(
        private readonly UpdateUserOutputPort $output,
        private readonly UserRepository $userRepository,
        private readonly DepartmentRepository $departmentRepository,
        private readonly UserFactory $userFactory
    ) {
    }

    /**
     * @param  UpdateUserRequestModel  $request
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function updateUser(UpdateUserRequestModel $request): ViewModel
    {
        $userUpdated = $this->userFactory->makeFromUpdateRequest($request);

        // Try to get user
        try {
            $user = $this->userRepository->getById($userUpdated->getId());
        } catch (\Exception $e) {
            return $this->output->noSuchUser(
                App()->makeWith(UpdateUserResponseModel::class, ['user' => $userUpdated])
            );
        }

        // Try to get department
        try {
            $department = $this->departmentRepository->getById($userUpdated->getDepartmentId());
        } catch (\Exception $e) {
            return $this->output->noSuchDepartment(
                App()->makeWith(UpdateUserResponseModel::class, ['user' => $userUpdated])
            );
        }

        // Try to update
        try {
            $userUpdated = $this->userRepository->update($userUpdated);
        } catch (\Exception $e) {
            return $this->output->unableToUpdateUser(
                App()->makeWith(UpdateUserResponseModel::class, ['user' => $userUpdated]),
                $e
            );
        }

        return $this->output->userUpdated(
            App()->makeWith(UpdateUserResponseModel::class, ['user' => $userUpdated])
        );
    }
}
