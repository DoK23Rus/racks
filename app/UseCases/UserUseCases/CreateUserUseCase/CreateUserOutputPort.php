<?php

namespace App\UseCases\UserUseCases\CreateUserUseCase;

use App\Domain\Interfaces\ViewModel;

interface CreateUserOutputPort
{
    public function userCreated(CreateUserResponseModel $response): ViewModel;

    public function userAlreadyExists(CreateUserResponseModel $response): ViewModel;

    public function noSuchDepartment(CreateUserResponseModel $response): ViewModel;

    public function unableToCreateUser(CreateUserResponseModel $response, \Throwable $e): ViewModel;
}
