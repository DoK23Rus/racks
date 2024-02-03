<?php

namespace App\UseCases\UserUseCases\ResetUserPasswordUseCase;

use App\Domain\Interfaces\UserInterfaces\UserEntity;

class ResetUserPasswordResponseModel
{
    public function __construct(
        private readonly UserEntity $user
    ) {
    }

    public function getUser(): UserEntity
    {
        return $this->user;
    }
}
