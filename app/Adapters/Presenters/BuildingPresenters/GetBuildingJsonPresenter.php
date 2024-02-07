<?php

namespace App\Adapters\Presenters\BuildingPresenters;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Domain\Interfaces\ViewModel;
use App\Http\Resources\BuildingResources\NoSuchBuildingResource;
use App\Http\Resources\BuildingResources\RetrieveBuildingResource;
use App\UseCases\BuildingUseCases\GetBuildingUseCase\GetBuildingOutputPort;
use App\UseCases\BuildingUseCases\GetBuildingUseCase\GetBuildingResponseModel;

class GetBuildingJsonPresenter implements GetBuildingOutputPort
{
    public function retrieveBuilding(GetBuildingResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    RetrieveBuildingResource::class, ['building' => $response->getBuilding()]),
                'statusCode' => 200,
            ]
        );
    }

    public function noSuchBuilding(GetBuildingResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    NoSuchBuildingResource::class),
                'statusCode' => 404,
            ]
        );
    }
}
