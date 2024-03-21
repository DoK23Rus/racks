<?php

namespace App\UseCases\DepartmentUseCases\DeleteDepartmentUseCase;

use App\Domain\Interfaces\ViewModel;

interface DeleteDepartmentInputPort
{
    /**
     * @param  DeleteDepartmentRequestModel  $request
     * @return ViewModel
     */
    public function deleteDepartment(DeleteDepartmentRequestModel $request): ViewModel;
}
