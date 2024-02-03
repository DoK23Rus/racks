<?php

namespace App\UseCases\UserUseCases\CreateUserUseCase;

use App\Domain\Interfaces\UserInterfaces\UserEntity;

class CreateUserResponseModel
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
