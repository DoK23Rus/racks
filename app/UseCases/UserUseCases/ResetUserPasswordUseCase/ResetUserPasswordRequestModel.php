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

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->attributes['id'] ?? 0;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->attributes['password'] ?? '';
    }
}
