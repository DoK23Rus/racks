<?php

namespace App\UseCases\BuildingUseCases\UpdateBuildingUseCase;

use App\Models\User;

class UpdateBuildingRequestModel
{
    /**
     * @param  array<mixed>  $attributes
     */
    public function __construct(
        private readonly array $attributes,
        private readonly int $id,
        private readonly User $user
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->attributes['name'];
    }

    public function getUserName(): string
    {
        return $this->user['name'];
    }
}
