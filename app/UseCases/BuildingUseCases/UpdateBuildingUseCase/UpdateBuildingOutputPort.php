<?php

namespace App\UseCases\BuildingUseCases\UpdateBuildingUseCase;

use App\Domain\Interfaces\ViewModel;

interface UpdateBuildingOutputPort
{
    public function buildingUpdated(UpdateBuildingResponseModel $response): ViewModel;

    public function noSuchBuilding(UpdateBuildingResponseModel $response): ViewModel;

    public function buildingNameException(UpdateBuildingResponseModel $response): ViewModel;

    public function unableToUpdateBuilding(UpdateBuildingResponseModel $response, \Throwable $e): ViewModel;

    public function permissionException(UpdateBuildingResponseModel $response): ViewModel;
}
