<?php

namespace App\UseCases\RegionUseCases\DeleteRegionUseCase;

use App\Domain\Interfaces\RegionInterfaces\RegionEntity;

class DeleteRegionResponseModel
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
