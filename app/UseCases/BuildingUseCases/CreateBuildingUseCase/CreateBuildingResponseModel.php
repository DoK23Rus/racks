<?php

namespace App\UseCases\BuildingUseCases\CreateBuildingUseCase;

use App\Domain\Interfaces\BuildingInterfaces\BuildingEntity;

class CreateBuildingResponseModel
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
