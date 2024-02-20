<?php

namespace App\UseCases\UserUseCases\ResetUserPasswordUseCase;

use App\Domain\Interfaces\ViewModel;

interface ResetUserPasswordInputPort
{
    /**
     * @param  ResetUserPasswordRequestModel  $request
     * @return ViewModel
     */
    public function resetUserPassword(ResetUserPasswordRequestModel $request): ViewModel;
}
