<?php

namespace App\UseCases\BuildingUseCases\CreateBuildingUseCase;

use App\Models\User;

class CreateBuildingRequestModel
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
    public function getName(): string
    {
        return $this->attributes['name'];
    }

    /**
     * @return int
     */
    public function getSiteId(): int
    {
        return $this->attributes['site_id'];
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->user['name'];
    }
}
