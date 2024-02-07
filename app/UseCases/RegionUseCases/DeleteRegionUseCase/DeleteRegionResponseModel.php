<?php

namespace App\UseCases\RegionUseCases\DeleteRegionUseCase;

use App\Domain\Interfaces\RegionInterfaces\RegionEntity;

class DeleteRegionResponseModel
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
