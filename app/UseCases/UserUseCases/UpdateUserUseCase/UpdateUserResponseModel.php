<?php

namespace App\UseCases\UserUseCases\UpdateUserUseCase;

use App\Domain\Interfaces\UserInterfaces\UserEntity;

class UpdateUserResponseModel
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
