<?php

namespace App\UseCases\BuildingUseCases\DeleteBuildingUseCase;

use App\Domain\Interfaces\ViewModel;

interface DeleteBuildingOutputPort
{
    public function buildingDeleted(DeleteBuildingResponseModel $response): ViewModel;

    public function noSuchBuilding(DeleteBuildingResponseModel $response): ViewModel;

    public function unableToDeleteBuilding(DeleteBuildingResponseModel $response, \Throwable $e): ViewModel;

    public function permissionException(DeleteBuildingResponseModel $response): ViewModel;
}
