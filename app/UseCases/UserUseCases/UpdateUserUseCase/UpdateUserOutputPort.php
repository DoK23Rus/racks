<?php

namespace App\UseCases\UserUseCases\UpdateUserUseCase;

use App\Domain\Interfaces\ViewModel;

interface UpdateUserOutputPort
{
    /**
     * @param  UpdateUserResponseModel  $response
     * @return ViewModel
     */
    public function userUpdated(UpdateUserResponseModel $response): ViewModel;

    /**
     * @param  UpdateUserResponseModel  $response
     * @return ViewModel
     */
    public function noSuchUser(UpdateUserResponseModel $response): ViewModel;

    /**
     * @param  UpdateUserResponseModel  $response
     * @return ViewModel
     */
    public function noSuchDepartment(UpdateUserResponseModel $response): ViewModel;

    /**
     * @param  UpdateUserResponseModel  $response
     * @param  \Throwable  $e
     * @return ViewModel
     */
    public function unableToUpdateUser(UpdateUserResponseModel $response, \Throwable $e): ViewModel;
}
