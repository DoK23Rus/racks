<?php

namespace App\Factories;

use App\Domain\Interfaces\BuildingInterfaces\BuildingBusinessRules;
use App\Domain\Interfaces\BuildingInterfaces\BuildingEntity;
use App\Domain\Interfaces\BuildingInterfaces\BuildingFactory;
use App\Models\Building;
use App\UseCases\BuildingUseCases\CreateBuildingUseCase\CreateBuildingRequestModel;
use App\UseCases\BuildingUseCases\UpdateBuildingUseCase\UpdateBuildingRequestModel;

class BuildingModelFactory implements BuildingFactory
{
    public function makeFromId(int $id): BuildingEntity
    {
        return new Building([
            'id' => $id,
        ]);
    }

    public function makeFromCreateRequest(CreateBuildingRequestModel $request): BuildingEntity|BuildingBusinessRules
    {
        return new Building([
            'name' => $request->getName(),
            'site_id' => $request->getSiteId(),
        ]);
    }

    public function makeFromPutRequest(UpdateBuildingRequestModel $request): BuildingEntity|BuildingBusinessRules
    {
        return new Building([
            'id' => $request->getId(),
            'name' => $request->getName(),
        ]);
    }
}
