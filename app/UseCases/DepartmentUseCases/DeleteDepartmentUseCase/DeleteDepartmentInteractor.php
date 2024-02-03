<?php

namespace App\UseCases\DepartmentUseCases\DeleteDepartmentUseCase;

use App\Domain\Interfaces\DepartmentInterfaces\DepartmentFactory;
use App\Domain\Interfaces\DepartmentInterfaces\DepartmentRepository;
use App\Domain\Interfaces\ViewModel;
use App\UseCases\DepartmentUseCases\UpdateDepartmentUseCase\UpdateDepartmentResponseModel;

class DeleteDepartmentInteractor implements DeleteDepartmentInputPort
{
    public function __construct(
        private readonly DeleteDepartmentOutputPort $output,
        private readonly DepartmentRepository $departmentRepository,
        private readonly DepartmentFactory $departmentFactory,
    ) {
    }

    public function deleteDepartment(DeleteDepartmentRequestModel $request): ViewModel
    {
        $department = $this->departmentFactory->makeFromId($request->getId());

        try {
            $department = $this->departmentRepository->getById($department->getId());
        } catch (\Exception $e) {
            return $this->output->noSuchDepartment(
                App()->makeWith(DeleteDepartmentResponseModel::class, ['department' => $department])
            );
        }

        try {
            $this->departmentRepository->delete($department);
        } catch (\Exception $e) {
            return $this->output->unableToDeleteDepartment(
                App()->makeWith(UpdateDepartmentResponseModel::class, ['department' => $department]),
                $e
            );
        }

        return $this->output->departmentDeleted(
            App()->makeWith(DeleteDepartmentResponseModel::class, ['department' => $department])
        );
    }
}
