<?php

namespace App\UseCases\DepartmentUseCases\CreateDepartmentUseCase;

use App\Domain\Interfaces\ViewModel;

interface CreateDepartmentOutputPort
{
    public function departmentCreated(CreateDepartmentResponseModel $response): ViewModel;

    public function departmentAlreadyExists(CreateDepartmentResponseModel $response): ViewModel;

    public function noSuchRegion(CreateDepartmentResponseModel $response): ViewModel;

    public function unableToCreateDepartment(CreateDepartmentResponseModel $response, \Throwable $e): ViewModel;
}
