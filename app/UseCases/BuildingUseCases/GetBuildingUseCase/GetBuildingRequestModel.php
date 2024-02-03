<?php

namespace App\UseCases\BuildingUseCases\GetBuildingUseCase;

class GetBuildingRequestModel
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
