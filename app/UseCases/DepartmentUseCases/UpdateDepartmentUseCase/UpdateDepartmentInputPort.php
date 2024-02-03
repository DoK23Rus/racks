<?php

namespace App\UseCases\DepartmentUseCases\UpdateDepartmentUseCase;

use App\Domain\Interfaces\ViewModel;

interface UpdateDepartmentInputPort
{
    public function updateDepartment(UpdateDepartmentRequestModel $request): ViewModel;
}
