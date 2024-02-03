<?php

namespace App\UseCases\BuildingUseCases\CreateBuildingUseCase;

use App\Domain\Interfaces\ViewModel;

interface CreateBuildingOutputPort
{
    public function buildingCreated(CreateBuildingResponseModel $response): ViewModel;

    public function buildingNameException(CreateBuildingResponseModel $response): ViewModel;

    public function noSuchSite(CreateBuildingResponseModel $response): ViewModel;

    public function unableToCreateBuilding(CreateBuildingResponseModel $response, \Throwable $e): ViewModel;

    public function permissionException(CreateBuildingResponseModel $response): ViewModel;
}
