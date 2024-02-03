<?php

namespace App\UseCases\BuildingUseCases\UpdateBuildingUseCase;

use App\Domain\Interfaces\ViewModel;

interface UpdateBuildingInputPort
{
    public function updateBuilding(UpdateBuildingRequestModel $request): ViewModel;
}
