<?php

namespace App\UseCases\UserUseCases\UpdateUserUseCase;

use App\Domain\Interfaces\ViewModel;

interface UpdateUserOutputPort
{
    public function userUpdated(UpdateUserResponseModel $response): ViewModel;

    public function noSuchUser(UpdateUserResponseModel $response): ViewModel;

    public function noSuchDepartment(UpdateUserResponseModel $response): ViewModel;

    public function unableToUpdateUser(UpdateUserResponseModel $response, \Throwable $e): ViewModel;
}
