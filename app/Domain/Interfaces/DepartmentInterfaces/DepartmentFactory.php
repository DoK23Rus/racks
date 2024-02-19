<?php

namespace App\Domain\Interfaces\DepartmentInterfaces;

use App\UseCases\DepartmentUseCases\CreateDepartmentUseCase\CreateDepartmentRequestModel;
use App\UseCases\DepartmentUseCases\UpdateDepartmentUseCase\UpdateDepartmentRequestModel;

interface DepartmentFactory
{
    /**
     * @param  CreateDepartmentRequestModel  $request
     * @return DepartmentEntity
     */
    public function makeFromCreateRequest(CreateDepartmentRequestModel $request): DepartmentEntity;

    /**
     * @param  UpdateDepartmentRequestModel  $request
     * @return DepartmentEntity
     */
    public function makeFromPatchRequest(UpdateDepartmentRequestModel $request): DepartmentEntity;
}
