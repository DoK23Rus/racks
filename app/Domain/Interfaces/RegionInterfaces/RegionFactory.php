<?php

namespace App\Domain\Interfaces\RegionInterfaces;

use App\UseCases\RegionUseCases\CreateRegionUseCase\CreateRegionRequestModel;
use App\UseCases\RegionUseCases\UpdateRegionUseCase\UpdateRegionRequestModel;

interface RegionFactory
{
    /**
     * @param  CreateRegionRequestModel  $request
     * @return RegionEntity
     */
    public function makeFromCreateRequest(CreateRegionRequestModel $request): RegionEntity;

    /**
     * @param  UpdateRegionRequestModel  $request
     * @return RegionEntity
     */
    public function makeFromPatchRequest(UpdateRegionRequestModel $request): RegionEntity;
}
