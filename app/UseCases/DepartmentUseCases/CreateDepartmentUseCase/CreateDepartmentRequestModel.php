<?php

namespace App\UseCases\DepartmentUseCases\CreateDepartmentUseCase;

class CreateDepartmentRequestModel
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
        return $this->attributes['name'];
    }

    /**
     * @return int
     */
    public function getRegionId(): int
    {
        return $this->attributes['region_id'];
    }
}
