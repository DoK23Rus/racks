<?php

namespace App\UseCases\UserUseCases\UpdateUserUseCase;

use App\Domain\Interfaces\DepartmentInterfaces\DepartmentFactory;
use App\Domain\Interfaces\DepartmentInterfaces\DepartmentRepository;
use App\Domain\Interfaces\UserInterfaces\UserFactory;
use App\Domain\Interfaces\UserInterfaces\UserRepository;
use App\Domain\Interfaces\ViewModel;

class UpdateUserInteractor implements UpdateUserInputPort
{
    public function __construct(
        private UpdateUserOutputPort $output,
        private UserRepository $userRepository,
        private DepartmentRepository $departmentRepository,
        private DepartmentFactory $departmentFactory,
        private UserFactory $userFactory,
    ) {
    }

    public function updateUser(UpdateUserRequestModel $request): ViewModel
    {
        $userUpdated = $this->userFactory->makeFromUpdateRequest($request);

        try {
            $user = $this->userRepository->getById($userUpdated->getId());
        } catch (\Exception $e) {
            return $this->output->noSuchUser(
                App()->makeWith(UpdateUserResponseModel::class, ['user' => $userUpdated])
            );
        }

        $department = $this->departmentFactory->makeFromId($userUpdated->getDepartmentId());

        try {
            $department = $this->departmentRepository->getById($department->getId());
        } catch (\Exception $e) {
            return $this->output->noSuchDepartment(
                App()->makeWith(UpdateUserResponseModel::class, ['user' => $userUpdated])
            );
        }

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
