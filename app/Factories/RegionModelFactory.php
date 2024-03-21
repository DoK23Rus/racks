<?php

namespace App\Factories;

use App\Domain\Interfaces\RegionInterfaces\RegionEntity;
use App\Domain\Interfaces\RegionInterfaces\RegionFactory;
use App\Models\Region;
use App\UseCases\RegionUseCases\CreateRegionUseCase\CreateRegionRequestModel;
use App\UseCases\RegionUseCases\UpdateRegionUseCase\UpdateRegionRequestModel;

class RegionModelFactory implements RegionFactory
{
    /**
     * @param  CreateRegionRequestModel  $request
     * @return RegionEntity
     */
    public function makeFromCreateRequest(CreateRegionRequestModel $request): RegionEntity
    {
        return new Region([
            'name' => $request->getName(),
        ]);
    }

    /**
     * @param  UpdateRegionRequestModel  $request
     * @return RegionEntity
     */
    public function makeFromPatchRequest(UpdateRegionRequestModel $request): RegionEntity
    {
        return new Region([
            'id' => $request->getId(),
            'name' => $request->getName(),
        ]);
    }
}
