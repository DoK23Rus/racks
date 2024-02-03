<?php

namespace App\UseCases\DepartmentUseCases\UpdateDepartmentUseCase;

use App\Domain\Interfaces\DepartmentInterfaces\DepartmentEntity;

class UpdateDepartmentResponseModel
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
