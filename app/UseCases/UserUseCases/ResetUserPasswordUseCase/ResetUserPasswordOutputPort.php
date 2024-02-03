<?php

namespace App\UseCases\UserUseCases\ResetUserPasswordUseCase;

use App\Domain\Interfaces\ViewModel;

interface ResetUserPasswordOutputPort
{
    public function passwordReseted(ResetUserPasswordResponseModel $response): ViewModel;

    public function noSuchUser(ResetUserPasswordResponseModel $response): ViewModel;

    public function unableToResetPassword(ResetUserPasswordResponseModel $response, \Throwable $e): ViewModel;
}
