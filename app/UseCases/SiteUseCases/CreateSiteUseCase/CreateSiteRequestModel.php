<?php

namespace App\UseCases\SiteUseCases\CreateSiteUseCase;

use App\Models\User;

class CreateSiteRequestModel
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
        return $this->attributes['name'] ?? '';
    }

    /**
     * @return int
     */
    public function getDepartmentId(): int
    {
        return $this->attributes['department_id'];
    }
}
