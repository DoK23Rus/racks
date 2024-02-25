<?php

namespace App\UseCases\BuildingUseCases\UpdateBuildingUseCase;

use App\Models\User;

class UpdateBuildingRequestModel
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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->attributes['name'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->attributes['description'] ?? null;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->user['name'];
    }

    public function getSiteId(): ?int
    {
        return null;
    }

    public function getDepartmentId(): ?int
    {
        return null;
    }
}
