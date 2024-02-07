<?php

namespace App\UseCases\RegionUseCases\GetRegionUseCase;

use App\Domain\Interfaces\RegionInterfaces\RegionEntity;

class GetRegionResponseModel
{
    public function __construct(
        private readonly ?RegionEntity $region
    ) {
    }

    public function getRegion(): ?RegionEntity
    {
        return $this->region;
    }
}
