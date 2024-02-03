<?php

namespace App\UseCases\BuildingUseCases\DeleteBuildingUseCase;

use App\Domain\Interfaces\BuildingInterfaces\BuildingEntity;

class DeleteBuildingResponseModel
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
