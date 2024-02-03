<?php

namespace App\UseCases\RackUseCases\GetRackUseCase;

class GetRackRequestModel
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
