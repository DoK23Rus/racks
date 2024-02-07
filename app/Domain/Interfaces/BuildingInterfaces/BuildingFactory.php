<?php

namespace App\Domain\Interfaces\BuildingInterfaces;

use App\UseCases\BuildingUseCases\CreateBuildingUseCase\CreateBuildingRequestModel;
use App\UseCases\BuildingUseCases\UpdateBuildingUseCase\UpdateBuildingRequestModel;

interface BuildingFactory
{
    public function makeFromCreateRequest(CreateBuildingRequestModel $request): BuildingEntity|BuildingBusinessRules;

    public function makeFromPatchRequest(UpdateBuildingRequestModel $request): BuildingEntity|BuildingBusinessRules;
}
