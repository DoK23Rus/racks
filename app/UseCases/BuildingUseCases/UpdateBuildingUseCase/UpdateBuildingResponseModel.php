<?php

namespace App\UseCases\BuildingUseCases\UpdateBuildingUseCase;

use App\Domain\Interfaces\BuildingInterfaces\BuildingEntity;

class UpdateBuildingResponseModel
{
    /**
     * @param  BuildingEntity  $building
     */
    public function __construct(
        private readonly BuildingEntity $building
    ) {
    }

    /**
     * @return BuildingEntity
     */
    public function getBuilding(): BuildingEntity
    {
        return $this->building;
    }
}
