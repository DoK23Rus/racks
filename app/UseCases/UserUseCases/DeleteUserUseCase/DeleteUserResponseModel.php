<?php

namespace App\UseCases\UserUseCases\DeleteUserUseCase;

use App\Domain\Interfaces\UserInterfaces\UserEntity;

class DeleteUserResponseModel
{
    /**
     * @param  UserEntity|null  $user  Null for no such user response
     */
    public function __construct(
        private readonly ?UserEntity $user
    ) {
    }

    /**
     * @return UserEntity|null
     */
    public function getUser(): ?UserEntity
    {
        return $this->user;
    }
}
