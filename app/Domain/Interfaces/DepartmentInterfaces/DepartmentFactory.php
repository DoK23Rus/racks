<?php

namespace App\Domain\Interfaces\DepartmentInterfaces;

use App\UseCases\DepartmentUseCases\CreateDepartmentUseCase\CreateDepartmentRequestModel;
use App\UseCases\DepartmentUseCases\UpdateDepartmentUseCase\UpdateDepartmentRequestModel;

interface DepartmentFactory
{
    public function makeFromCreateRequest(CreateDepartmentRequestModel $request): DepartmentEntity;

    public function makeFromPatchRequest(UpdateDepartmentRequestModel $request): DepartmentEntity;
}
