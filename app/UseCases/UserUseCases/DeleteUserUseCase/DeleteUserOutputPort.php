<?php

namespace App\UseCases\UserUseCases\DeleteUserUseCase;

use App\Domain\Interfaces\ViewModel;

interface DeleteUserOutputPort
{
    public function userDeleted(DeleteUserResponseModel $response): ViewModel;

    public function noSuchUser(DeleteUserResponseModel $response): ViewModel;

    public function unableToDeleteUser(DeleteUserResponseModel $response, \Throwable $e): ViewModel;
}
