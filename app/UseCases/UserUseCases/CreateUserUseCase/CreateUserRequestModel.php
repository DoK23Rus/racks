<?php

namespace App\UseCases\UserUseCases\CreateUserUseCase;

class CreateUserRequestModel
{
    /**
     * @param  array<mixed>  $attributes
     */
    public function __construct(
        private readonly array $attributes
    ) {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->attributes['name'] ?? '';
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->attributes['full_name'] ?? '';
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->attributes['email'] ?? '';
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->attributes['password'] ?? '';
    }

    /**
     * @return int
     */
    public function getDepartmentId(): int
    {
        return $this->attributes['department_id'] ?? 0;
    }
}
