<?php

namespace App\UseCases\BuildingUseCases\CreateBuildingUseCase;

use App\Domain\Interfaces\BuildingInterfaces\BuildingEntity;

class CreateBuildingResponseModel
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
