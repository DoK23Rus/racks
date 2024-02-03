<?php

namespace App\UseCases\RegionUseCases\GetRegionUseCase;

class GetRegionRequestModel
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
