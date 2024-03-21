<?php

namespace App\UseCases\UserUseCases\ResetUserPasswordUseCase;

use App\Domain\Interfaces\ViewModel;

interface ResetUserPasswordOutputPort
{
    /**
     * @param  ResetUserPasswordResponseModel  $response
     * @return ViewModel
     */
    public function passwordReseted(ResetUserPasswordResponseModel $response): ViewModel;

    /**
     * @param  ResetUserPasswordResponseModel  $response
     * @return ViewModel
     */
    public function noSuchUser(ResetUserPasswordResponseModel $response): ViewModel;

    /**
     * @param  ResetUserPasswordResponseModel  $response
     * @param  \Throwable  $e
     * @return ViewModel
     */
    public function unableToResetPassword(ResetUserPasswordResponseModel $response, \Throwable $e): ViewModel;
}
