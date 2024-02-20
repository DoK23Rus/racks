<?php

namespace App\UseCases\DepartmentUseCases\DeleteDepartmentUseCase;

use App\Domain\Interfaces\DepartmentInterfaces\DepartmentEntity;

class DeleteDepartmentResponseModel
{
    /**
     * @param  DepartmentEntity|null  $department  Null for no such department response
     */
    public function __construct(
        private readonly ?DepartmentEntity $department
    ) {
    }

    /**
     * @return DepartmentEntity|null
     */
    public function getDepartment(): ?DepartmentEntity
    {
        return $this->department;
    }
}
