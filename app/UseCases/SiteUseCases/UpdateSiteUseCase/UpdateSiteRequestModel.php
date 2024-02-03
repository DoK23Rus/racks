<?php

namespace App\UseCases\SiteUseCases\UpdateSiteUseCase;

use App\Models\User;

class UpdateSiteRequestModel
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

    public function getUserName(): string
    {
        return $this->user['name'];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->attributes['name'];
    }
}
