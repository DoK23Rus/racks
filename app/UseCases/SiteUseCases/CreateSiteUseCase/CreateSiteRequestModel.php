<?php

namespace App\UseCases\SiteUseCases\CreateSiteUseCase;

use App\Models\User;

class CreateSiteRequestModel
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
        return $this->attributes['name'] ?? '';
    }

    public function getDepartmentId(): int
    {
        return $this->attributes['department_id'];
    }
}
