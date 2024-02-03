<?php

namespace App\UseCases\RoomUseCases\DeleteRoomUseCase;

use App\Models\User;

class DeleteRoomRequestModel
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
