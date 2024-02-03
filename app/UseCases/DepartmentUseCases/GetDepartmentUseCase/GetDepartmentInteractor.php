<?php

namespace App\UseCases\DepartmentUseCases\GetDepartmentUseCase;

use App\Domain\Interfaces\DepartmentInterfaces\DepartmentFactory;
use App\Domain\Interfaces\DepartmentInterfaces\DepartmentRepository;
use App\Domain\Interfaces\ViewModel;

class GetDepartmentInteractor implements GetDepartmentInputPort
{
    public function __construct(
        private readonly GetDepartmentOutputPort $output,
        private readonly DepartmentRepository $departmentRepository,
        private readonly DepartmentFactory $departmentFactory
    ) {
    }

    public function getDepartment(GetDepartmentRequestModel $request): ViewModel
    {
        $department = $this->departmentFactory->makeFromId($request->getId());

        try {
            $department = $this->departmentRepository->getById($department->getId());
        } catch (\Exception $e) {
            return $this->output->noSuchDepartment(
                App()->makeWith(GetDepartmentResponseModel::class, ['department' => $department])
            );
        }

        return $this->output->retrieveDepartment(
            App()->makeWith(GetDepartmentResponseModel::class, ['department' => $department])
        );
    }
}
