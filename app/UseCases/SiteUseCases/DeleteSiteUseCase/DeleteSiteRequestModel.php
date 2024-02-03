<?php

namespace App\UseCases\SiteUseCases\DeleteSiteUseCase;

use App\Models\User;

class DeleteSiteRequestModel
{
    public function __construct(
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
}
