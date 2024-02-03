<?php

namespace App\Domain\Interfaces\RegionInterfaces;

use App\UseCases\RegionUseCases\CreateRegionUseCase\CreateRegionRequestModel;
use App\UseCases\RegionUseCases\UpdateRegionUseCase\UpdateRegionRequestModel;

interface RegionFactory
{
    public function makeFromId(int $id): RegionEntity;

    public function makeFromCreateRequest(CreateRegionRequestModel $request): RegionEntity;

    public function makeFromPutRequest(UpdateRegionRequestModel $request): RegionEntity;
}
