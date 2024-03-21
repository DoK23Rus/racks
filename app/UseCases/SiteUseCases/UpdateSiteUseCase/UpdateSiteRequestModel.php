<?php

namespace App\UseCases\SiteUseCases\UpdateSiteUseCase;

use App\Models\User;

class UpdateSiteRequestModel
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

    public function getDepartmentId(): ?int
    {
        return null;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->attributes['description'] ?? null;
    }
}
