<?php

namespace App\UseCases\UserUseCases\DeleteUserUseCase;

use App\Domain\Interfaces\ViewModel;

interface DeleteUserOutputPort
{
    /**
     * @param  DeleteUserResponseModel  $response
     * @return ViewModel
     */
    public function userDeleted(DeleteUserResponseModel $response): ViewModel;

    /**
     * @param  DeleteUserResponseModel  $response
     * @return ViewModel
     */
    public function noSuchUser(DeleteUserResponseModel $response): ViewModel;

    /**
     * @param  DeleteUserResponseModel  $response
     * @param  \Throwable  $e
     * @return ViewModel
     */
    public function unableToDeleteUser(DeleteUserResponseModel $response, \Throwable $e): ViewModel;
}
