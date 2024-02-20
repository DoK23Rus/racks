<?php

namespace App\UseCases\RoomUseCases\CreateRoomUseCase;

use App\Models\User;

class CreateRoomRequestModel
{
    /**
     * @param  array<mixed>  $attributes
     * @param  User  $user
     */
    public function __construct(
        private readonly array $attributes,
        private readonly User $user
    ) {
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->user['name'];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->attributes['name'];
    }

    /**
     * @return int
     */
    public function getBuildingId(): int
    {
        return $this->attributes['building_id'];
    }
}
