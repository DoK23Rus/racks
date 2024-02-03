<?php

namespace App\UseCases\UserUseCases\UpdateUserUseCase;

class UpdateUserRequestModel
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

    public function getName(): string
    {
        return $this->attributes['name'] ?? '';
    }

    public function getFullName(): string
    {
        return $this->attributes['full_name'] ?? '';
    }

    public function getEmail(): string
    {
        return $this->attributes['email'] ?? '';
    }

    public function getDepartmentId(): int
    {
        return $this->attributes['department_id'] ?? 0;
    }
}
