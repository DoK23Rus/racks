<?php

namespace App\UseCases\DepartmentUseCases\DeleteDepartmentUseCase;

use App\Domain\Interfaces\ViewModel;

interface DeleteDepartmentOutputPort
{
    /**
     * @param  DeleteDepartmentResponseModel  $response
     * @return ViewModel
     */
    public function departmentDeleted(DeleteDepartmentResponseModel $response): ViewModel;

    /**
     * @param  DeleteDepartmentResponseModel  $response
     * @return ViewModel
     */
    public function noSuchDepartment(DeleteDepartmentResponseModel $response): ViewModel;

    /**
     * @param  DeleteDepartmentResponseModel  $response
     * @param  \Throwable  $e
     * @return ViewModel
     */
    public function unableToDeleteDepartment(DeleteDepartmentResponseModel $response, \Throwable $e): ViewModel;
}
