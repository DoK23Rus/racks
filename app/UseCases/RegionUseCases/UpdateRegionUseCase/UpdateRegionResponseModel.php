<?php

namespace App\UseCases\RegionUseCases\UpdateRegionUseCase;

use App\Domain\Interfaces\RegionInterfaces\RegionEntity;

class UpdateRegionResponseModel
{
    /**
     * @param  RegionEntity  $region
     */
    public function __construct(
        private readonly RegionEntity $region
    ) {
    }

    /**
     * @return RegionEntity
     */
    public function getRegion(): RegionEntity
    {
        return $this->region;
    }
}
