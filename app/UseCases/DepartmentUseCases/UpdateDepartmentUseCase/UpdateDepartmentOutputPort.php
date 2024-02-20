<?php

namespace App\UseCases\DepartmentUseCases\UpdateDepartmentUseCase;

use App\Domain\Interfaces\ViewModel;

interface UpdateDepartmentOutputPort
{
    /**
     * @param  UpdateDepartmentResponseModel  $response
     * @return ViewModel
     */
    public function departmentUpdated(UpdateDepartmentResponseModel $response): ViewModel;

    /**
     * @param  UpdateDepartmentResponseModel  $response
     * @return ViewModel
     */
    public function noSuchDepartment(UpdateDepartmentResponseModel $response): ViewModel;

    /**
     * @param  UpdateDepartmentResponseModel  $response
     * @param  \Throwable  $e
     * @return ViewModel
     */
    public function unableToUpdateDepartment(UpdateDepartmentResponseModel $response, \Throwable $e): ViewModel;
}
