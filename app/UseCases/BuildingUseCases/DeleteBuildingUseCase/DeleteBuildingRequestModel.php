<?php

namespace App\UseCases\BuildingUseCases\DeleteBuildingUseCase;

use App\Models\User;

class DeleteBuildingRequestModel
{
    public function __construct(
        private readonly int $id,
        private readonly User $user
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserName(): string
    {
        return $this->user['name'];
    }
}
