<?php

namespace App\UseCases\BuildingUseCases\GetBuildingUseCase;

use App\Domain\Interfaces\ViewModel;

interface GetBuildingOutputPort
{
    public function retrieveBuilding(GetBuildingResponseModel $response): ViewModel;

    public function noSuchBuilding(GetBuildingResponseModel $response): ViewModel;
}
