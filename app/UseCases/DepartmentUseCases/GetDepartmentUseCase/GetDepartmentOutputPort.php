<?php

namespace App\UseCases\DepartmentUseCases\GetDepartmentUseCase;

use App\Domain\Interfaces\ViewModel;

interface GetDepartmentOutputPort
{
    public function retrieveDepartment(GetDepartmentResponseModel $response): ViewModel;

    public function noSuchDepartment(GetDepartmentResponseModel $response): ViewModel;
}
