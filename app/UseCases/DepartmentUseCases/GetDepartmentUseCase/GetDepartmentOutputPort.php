<?php

namespace App\UseCases\DepartmentUseCases\GetDepartmentUseCase;

use App\Domain\Interfaces\ViewModel;

interface GetDepartmentOutputPort
{
    /**
     * @param  GetDepartmentResponseModel  $response
     * @return ViewModel
     */
    public function retrieveDepartment(GetDepartmentResponseModel $response): ViewModel;

    /**
     * @param  GetDepartmentResponseModel  $response
     * @return ViewModel
     */
    public function noSuchDepartment(GetDepartmentResponseModel $response): ViewModel;
}
