<?php

namespace App\UseCases\DepartmentUseCases\CreateDepartmentUseCase;

use App\Domain\Interfaces\DepartmentInterfaces\DepartmentEntity;

class CreateDepartmentResponseModel
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
