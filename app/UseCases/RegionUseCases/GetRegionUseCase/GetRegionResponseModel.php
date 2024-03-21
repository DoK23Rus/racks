<?php

namespace App\UseCases\RegionUseCases\GetRegionUseCase;

use App\Domain\Interfaces\RegionInterfaces\RegionEntity;

class GetRegionResponseModel
{
    /**
     * @param  RegionEntity|null  $region  Null for no such region response
     */
    public function __construct(
        private readonly ?RegionEntity $region
    ) {
    }

    /**
     * @return RegionEntity|null
     */
    public function getRegion(): ?RegionEntity
    {
        return $this->region;
    }
}
