<?php

namespace App\UseCases\UserUseCases\DeleteUserUseCase;

use App\Domain\Interfaces\UserInterfaces\UserEntity;

class DeleteUserResponseModel
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
