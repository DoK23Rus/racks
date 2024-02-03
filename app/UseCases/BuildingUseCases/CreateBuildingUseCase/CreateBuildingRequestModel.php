<?php

namespace App\UseCases\BuildingUseCases\CreateBuildingUseCase;

use App\Models\User;

class CreateBuildingRequestModel
{
    /**
     * @param  array<mixed>  $attributes
     */
    public function __construct(
        private readonly array $attributes,
        private readonly User $user
    ) {
    }

    public function getName(): string
    {
        return $this->attributes['name'];
    }

    public function getSiteId(): int
    {
        return $this->attributes['site_id'];
    }

    public function getUserName(): string
    {
        return $this->user['name'];
    }
}
