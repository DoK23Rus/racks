<?php

namespace App\UseCases\DepartmentUseCases\CreateDepartmentUseCase;

use App\Domain\Interfaces\DepartmentInterfaces\DepartmentEntity;

class CreateDepartmentResponseModel
{
    /**
     * @param  DepartmentEntity  $department
     */
    public function __construct(
        private readonly DepartmentEntity $department
    ) {
    }

    /**
     * @return DepartmentEntity
     */
    public function getDepartment(): DepartmentEntity
    {
        return $this->department;
    }
}
