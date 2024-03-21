<?php

namespace App\UseCases\DepartmentUseCases\DeleteDepartmentUseCase;

class DeleteDepartmentRequestModel
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
        return $this->attributes['id'];
    }
}
