<?php

namespace App\UseCases\RackUseCases\DeleteRackUseCase;

use App\Models\User;

class DeleteRackRequestModel
{
    public function __construct(
        private readonly int $id,
        private readonly User $user
    ) {
    }

    public function getUserName(): string
    {
        return $this->user['name'];
    }

    public function getId(): int
    {
        return $this->id;
    }
}
