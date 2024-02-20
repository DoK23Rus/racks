<?php

namespace App\UseCases\BuildingUseCases\GetBuildingUseCase;

use App\Domain\Interfaces\BuildingInterfaces\BuildingEntity;

class GetBuildingResponseModel
{
    /**
     * @param  BuildingEntity|null  $building  Null for no such building response
     */
    public function __construct(
        private readonly ?BuildingEntity $building
    ) {
    }

    /**
     * @return BuildingEntity|null
     */
    public function getBuilding(): ?BuildingEntity
    {
        return $this->building;
    }
}
