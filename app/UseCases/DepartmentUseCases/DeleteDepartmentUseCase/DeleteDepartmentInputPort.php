<?php

namespace App\UseCases\DepartmentUseCases\DeleteDepartmentUseCase;

use App\Domain\Interfaces\ViewModel;

interface DeleteDepartmentInputPort
{
    public function deleteDepartment(DeleteDepartmentRequestModel $request): ViewModel;
}
