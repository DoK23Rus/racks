<?php

namespace App\UseCases\DepartmentUseCases\GetDepartmentUseCase;

use App\Domain\Interfaces\DepartmentInterfaces\DepartmentRepository;
use App\Domain\Interfaces\ViewModel;

class GetDepartmentInteractor implements GetDepartmentInputPort
{
    public function __construct(
        private readonly GetDepartmentOutputPort $output,
        private readonly DepartmentRepository $departmentRepository
    ) {
    }

    public function getDepartment(GetDepartmentRequestModel $request): ViewModel
    {
        try {
            $department = $this->departmentRepository->getById($request->getId());
        } catch (\Exception $e) {
            return $this->output->noSuchDepartment(
                App()->makeWith(GetDepartmentResponseModel::class, ['department' => null])
            );
        }

        return $this->output->retrieveDepartment(
            App()->makeWith(GetDepartmentResponseModel::class, ['department' => $department])
        );
    }
}
