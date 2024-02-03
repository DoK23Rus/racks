<?php

namespace App\UseCases\DeviceUseCases\DeleteDeviceUseCase;

use App\Models\User;

class DeleteDeviceRequestModel
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
