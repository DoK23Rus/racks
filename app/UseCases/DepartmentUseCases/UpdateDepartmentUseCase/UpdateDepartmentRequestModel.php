<?php

namespace App\UseCases\DepartmentUseCases\UpdateDepartmentUseCase;

class UpdateDepartmentRequestModel
{
    /**
     * @param  array<mixed>  $attributes
     */
    public function __construct(
        private readonly array $attributes
    ) {
    }

    public function getId(): string
    {
        return $this->attributes['id'];
    }

    public function getName(): string
    {
        return $this->attributes['name'];
    }
}
