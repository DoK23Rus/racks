<?php

namespace App\UseCases\BuildingUseCases\DeleteBuildingUseCase;

use App\Models\User;

class DeleteBuildingRequestModel
{
    /**
     * @param  int  $id
     * @param  User  $user
     */
    public function __construct(
        private readonly int $id,
        private readonly User $user
    ) {
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->user['name'];
    }
}
