<?php

namespace App\UseCases\SiteUseCases\DeleteSiteUseCase;

use App\Models\User;

class DeleteSiteRequestModel
{
    /**
     * @param  int  $id
     * @param  User  $user
     */
    public function __construct(
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
}
