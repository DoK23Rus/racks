<?php

namespace App\UseCases\DepartmentUseCases\DeleteDepartmentUseCase;

use App\Domain\Interfaces\ViewModel;

interface DeleteDepartmentOutputPort
{
    public function departmentDeleted(DeleteDepartmentResponseModel $response): ViewModel;

    public function noSuchDepartment(DeleteDepartmentResponseModel $response): ViewModel;

    public function unableToDeleteDepartment(DeleteDepartmentResponseModel $response, \Throwable $e): ViewModel;
}
