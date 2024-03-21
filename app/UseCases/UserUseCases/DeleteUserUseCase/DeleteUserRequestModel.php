<?php

namespace App\UseCases\UserUseCases\DeleteUserUseCase;

class DeleteUserRequestModel
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
}
