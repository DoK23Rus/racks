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
     * @return string
     */
    public function getName(): string
    {
        return $this->attributes['name'];
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->user['name'];
    }
}
