<?php

namespace App\UseCases\RegionUseCases\UpdateRegionUseCase;

use App\Domain\Interfaces\RegionInterfaces\RegionEntity;

class UpdateRegionResponseModel
{
    public function __construct(
        private readonly RegionEntity $region
    ) {
    }

    public function getRegion(): RegionEntity
    {
        return $this->region;
    }
}
