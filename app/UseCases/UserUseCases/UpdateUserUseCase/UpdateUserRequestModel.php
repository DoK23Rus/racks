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
     * @return int
     */
    public function getDepartmentId(): int
    {
        return $this->attributes['department_id'] ?? 0;
    }
}
