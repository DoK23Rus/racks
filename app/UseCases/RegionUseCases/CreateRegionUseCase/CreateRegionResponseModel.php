<?php

namespace App\UseCases\RegionUseCases\CreateRegionUseCase;

use App\Domain\Interfaces\RegionInterfaces\RegionEntity;

class CreateRegionResponseModel
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
