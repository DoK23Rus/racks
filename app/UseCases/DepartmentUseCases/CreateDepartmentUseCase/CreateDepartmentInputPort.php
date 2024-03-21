<?php

namespace App\UseCases\DepartmentUseCases\CreateDepartmentUseCase;

use App\Domain\Interfaces\ViewModel;

interface CreateDepartmentInputPort
{
    /**
     * @param  CreateDepartmentRequestModel  $request
     * @return ViewModel
     */
    public function createDepartment(CreateDepartmentRequestModel $request): ViewModel;
}
