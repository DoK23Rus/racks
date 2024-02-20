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

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->attributes['id'];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->attributes['name'];
    }
}
