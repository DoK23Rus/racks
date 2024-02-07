<?php

namespace App\UseCases\DepartmentUseCases\DeleteDepartmentUseCase;

use App\Domain\Interfaces\DepartmentInterfaces\DepartmentRepository;
use App\Domain\Interfaces\ViewModel;
use App\UseCases\DepartmentUseCases\UpdateDepartmentUseCase\UpdateDepartmentResponseModel;

class DeleteDepartmentInteractor implements DeleteDepartmentInputPort
{
    public function __construct(
        private readonly DeleteDepartmentOutputPort $output,
        private readonly DepartmentRepository $departmentRepository
    ) {
    }

    public function deleteDepartment(DeleteDepartmentRequestModel $request): ViewModel
    {
        try {
            $department = $this->departmentRepository->getById($request->getId());
        } catch (\Exception $e) {
            return $this->output->noSuchDepartment(
                App()->makeWith(DeleteDepartmentResponseModel::class, ['department' => null])
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
