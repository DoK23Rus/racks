<?php

namespace App\UseCases\BuildingUseCases\CreateBuildingUseCase;

use App\Domain\Interfaces\ViewModel;

interface CreateBuildingInputPort
{
    public function createBuilding(CreateBuildingRequestModel $request): ViewModel;
}
