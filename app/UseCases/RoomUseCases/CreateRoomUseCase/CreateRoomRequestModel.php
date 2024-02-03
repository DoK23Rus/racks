<?php

namespace App\UseCases\RoomUseCases\CreateRoomUseCase;

use App\Models\User;

class CreateRoomRequestModel
{
    /**
     * @param  array<mixed>  $attributes
     */
    public function __construct(
        private readonly array $attributes,
        private readonly User $user
    ) {
    }

    public function getUserName(): string
    {
        return $this->user['name'];
    }

    public function getName(): string
    {
        return $this->attributes['name'];
    }

    public function getBuildingId(): int
    {
        return $this->attributes['building_id'];
    }
}
