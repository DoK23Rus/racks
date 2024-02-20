<?php

namespace App\UseCases\DepartmentUseCases\GetDepartmentUseCase;

use App\Domain\Interfaces\ViewModel;

interface GetDepartmentInputPort
{
    /**
     * @param  GetDepartmentRequestModel  $request
     * @return ViewModel
     */
    public function getDepartment(GetDepartmentRequestModel $request): ViewModel;
}
