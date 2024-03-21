<?php

namespace App\UseCases\RoomUseCases\UpdateRoomUseCase;

use App\Models\User;

class UpdateRoomRequestModel
{
    /**
     * @param  array<mixed>  $attributes
     * @param  int  $id
     * @param  User  $user
     */
    public function __construct(
        private readonly array $attributes,
        private readonly int $id,
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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->attributes['name'] ?? null;
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

    public function getBuildingId(): ?int
    {
        return null;
    }

    public function getDepartmentId(): ?int
    {
        return null;
    }
}
