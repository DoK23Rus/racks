<?php

namespace App\UseCases\DepartmentUseCases\UpdateDepartmentUseCase;

use App\Domain\Interfaces\ViewModel;

interface UpdateDepartmentOutputPort
{
    public function departmentUpdated(UpdateDepartmentResponseModel $response): ViewModel;

    public function noSuchDepartment(UpdateDepartmentResponseModel $response): ViewModel;

    public function unableToUpdateDepartment(UpdateDepartmentResponseModel $response, \Throwable $e): ViewModel;
}
