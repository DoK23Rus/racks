<?php

namespace App\UseCases\UserUseCases\UpdateUserUseCase;

use App\Domain\Interfaces\UserInterfaces\UserEntity;

class UpdateUserResponseModel
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
