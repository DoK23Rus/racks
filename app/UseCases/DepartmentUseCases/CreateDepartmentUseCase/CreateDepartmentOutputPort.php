<?php

namespace App\UseCases\DepartmentUseCases\CreateDepartmentUseCase;

use App\Domain\Interfaces\ViewModel;

interface CreateDepartmentOutputPort
{
    /**
     * @param  CreateDepartmentResponseModel  $response
     * @return ViewModel
     */
    public function departmentCreated(CreateDepartmentResponseModel $response): ViewModel;

    /**
     * @param  CreateDepartmentResponseModel  $response
     * @return ViewModel
     */
    public function departmentAlreadyExists(CreateDepartmentResponseModel $response): ViewModel;

    /**
     * @param  CreateDepartmentResponseModel  $response
     * @return ViewModel
     */
    public function noSuchRegion(CreateDepartmentResponseModel $response): ViewModel;

    /**
     * @param  CreateDepartmentResponseModel  $response
     * @param  \Throwable  $e
     * @return ViewModel
     */
    public function unableToCreateDepartment(CreateDepartmentResponseModel $response, \Throwable $e): ViewModel;
}
