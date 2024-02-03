<?php

namespace App\UseCases\DepartmentUseCases\GetDepartmentUseCase;

class GetDepartmentRequestModel
{
    public function __construct(
        private readonly int $id
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }
}
