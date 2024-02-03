<?php

namespace App\Domain\Interfaces\BuildingInterfaces;

use App\UseCases\BuildingUseCases\CreateBuildingUseCase\CreateBuildingRequestModel;
use App\UseCases\BuildingUseCases\UpdateBuildingUseCase\UpdateBuildingRequestModel;

interface BuildingFactory
{
    public function makeFromId(int $id): BuildingEntity;

    public function makeFromCreateRequest(CreateBuildingRequestModel $request): BuildingEntity|BuildingBusinessRules;

    public function makeFromPutRequest(UpdateBuildingRequestModel $request): BuildingEntity|BuildingBusinessRules;
}
