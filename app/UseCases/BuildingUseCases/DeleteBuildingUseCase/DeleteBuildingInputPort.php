<?php

namespace App\UseCases\BuildingUseCases\DeleteBuildingUseCase;

use App\Domain\Interfaces\ViewModel;

interface DeleteBuildingInputPort
{
    public function deleteBuilding(DeleteBuildingRequestModel $request): ViewModel;
}
