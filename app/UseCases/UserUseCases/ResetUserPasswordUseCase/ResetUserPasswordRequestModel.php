<?php

namespace App\UseCases\UserUseCases\ResetUserPasswordUseCase;

class ResetUserPasswordRequestModel
{
    /**
     * @param  array<mixed>  $attributes
     */
    public function __construct(
        private readonly array $attributes
    ) {
    }

    public function getId(): int
    {
        return $this->attributes['id'] ?? 0;
    }

    public function getPassword(): string
    {
        return $this->attributes['password'] ?? '';
    }
}
