<?php

namespace App\UseCases\BuildingUseCases\UpdateBuildingUseCase;

use App\Domain\Interfaces\BuildingInterfaces\BuildingEntity;

class UpdateBuildingResponseModel
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
