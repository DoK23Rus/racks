<?php

namespace App\UseCases\UserUseCases\ResetUserPasswordUseCase;

use App\Domain\Interfaces\ViewModel;

interface ResetUserPasswordInputPort
{
    public function resetUserPassword(ResetUserPasswordRequestModel $request): ViewModel;
}
