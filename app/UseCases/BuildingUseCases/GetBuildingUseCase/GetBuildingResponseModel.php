<?php

namespace App\UseCases\BuildingUseCases\GetBuildingUseCase;

use App\Domain\Interfaces\BuildingInterfaces\BuildingEntity;

class GetBuildingResponseModel
{
    public function __construct(
        private readonly BuildingEntity $building
    ) {
    }

    public function getBuilding(): BuildingEntity
    {
        return $this->building;
    }
}
