<?php

namespace App\UseCases\UserUseCases\CreateUserUseCase;

class CreateUserRequestModel
{
    /**
     * @param  array<mixed>  $attributes
     */
    public function __construct(
        private array $attributes
    ) {
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

    public function getPassword(): string
    {
        return $this->attributes['password'] ?? '';
    }

    public function getDepartmentId(): int
    {
        return $this->attributes['department_id'] ?? 0;
    }
}
