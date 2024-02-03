<?php

namespace App\UseCases\DepartmentUseCases\GetDepartmentUseCase;

use App\Domain\Interfaces\ViewModel;

interface GetDepartmentInputPort
{
    public function getDepartment(GetDepartmentRequestModel $request): ViewModel;
}
