<?php

namespace App\UseCases\DepartmentUseCases\GetDepartmentUseCase;

use App\Domain\Interfaces\DepartmentInterfaces\DepartmentEntity;

class GetDepartmentResponseModel
{
    public function __construct(
        private readonly DepartmentEntity $department
    ) {
    }

    public function getDepartment(): DepartmentEntity
    {
        return $this->department;
    }
}
