<?php

namespace App\Domain\Interfaces\DepartmentInterfaces;

use App\UseCases\DepartmentUseCases\CreateDepartmentUseCase\CreateDepartmentRequestModel;
use App\UseCases\DepartmentUseCases\UpdateDepartmentUseCase\UpdateDepartmentRequestModel;

interface DepartmentFactory
{
    public function makeFromId(int $id): DepartmentEntity;

    public function makeFromCreateRequest(CreateDepartmentRequestModel $request): DepartmentEntity;

    public function makeFromPutRequest(UpdateDepartmentRequestModel $request): DepartmentEntity;
}
