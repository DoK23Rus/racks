<?php

namespace App\UseCases\BuildingUseCases\GetBuildingUseCase;

use App\Domain\Interfaces\ViewModel;

interface GetBuildingInputPort
{
    public function getBuilding(GetBuildingRequestModel $request): ViewModel;
}
