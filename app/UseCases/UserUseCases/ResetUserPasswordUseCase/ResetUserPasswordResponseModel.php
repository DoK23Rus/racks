<?php

namespace App\UseCases\UserUseCases\ResetUserPasswordUseCase;

use App\Domain\Interfaces\UserInterfaces\UserEntity;

class ResetUserPasswordResponseModel
{
    /**
     * @param  UserEntity  $user
     */
    public function __construct(
        private readonly UserEntity $user
    ) {
    }

    /**
     * @return UserEntity
     */
    public function getUser(): UserEntity
    {
        return $this->user;
    }
}
