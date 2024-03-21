<?php

namespace App\UseCases\UserUseCases\CreateUserUseCase;

use App\Domain\Interfaces\ViewModel;

interface CreateUserOutputPort
{
    /**
     * @param  CreateUserResponseModel  $response
     * @return ViewModel
     */
    public function userCreated(CreateUserResponseModel $response): ViewModel;

    /**
     * @param  CreateUserResponseModel  $response
     * @return ViewModel
     */
    public function userAlreadyExists(CreateUserResponseModel $response): ViewModel;

    /**
     * @param  CreateUserResponseModel  $response
     * @return ViewModel
     */
    public function noSuchDepartment(CreateUserResponseModel $response): ViewModel;

    /**
     * @param  CreateUserResponseModel  $response
     * @param  \Throwable  $e
     * @return ViewModel
     */
    public function unableToCreateUser(CreateUserResponseModel $response, \Throwable $e): ViewModel;
}
