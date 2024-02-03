<?php

namespace App\UseCases\RegionUseCases\CreateRegionUseCase;

use App\Domain\Interfaces\RegionInterfaces\RegionEntity;

class CreateRegionResponseModel
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
