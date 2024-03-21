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

    public function getBuildingFloor(): ?string
    {
        return $this->attributes['building_floor'] ?? null;
    }

    public function getDescription(): ?string
    {
        return $this->attributes['description'] ?? null;
    }

    public function getNumberOfRackSpaces(): ?int
    {
        return $this->attributes['number_of_rack_spaces'] ?? null;
    }

    public function getArea(): ?int
    {
        return $this->attributes['area'] ?? null;
    }

    public function getResponsible(): ?string
    {
        return $this->attributes['responsible'] ?? null;
    }

    public function getCoolingSystem(): ?string
    {
        return $this->attributes['cooling_system'] ?? null;
    }

    public function getFireSuppressionSystem(): ?string
    {
        return $this->attributes['fire_suppression_system'] ?? null;
    }

    public function getAccessIsOpen(): ?bool
    {
        return $this->attributes['access_is_open'] ?? null;
    }

    public function getHasRaisedFloor(): ?bool
    {
        return $this->attributes['has_raised_floor'] ?? null;
    }
}
