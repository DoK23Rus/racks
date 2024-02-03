<?php

namespace App\UseCases\DepartmentUseCases\CreateDepartmentUseCase;

use App\Domain\Interfaces\ViewModel;

interface CreateDepartmentInputPort
{
    public function createDepartment(CreateDepartmentRequestModel $request): ViewModel;
}
