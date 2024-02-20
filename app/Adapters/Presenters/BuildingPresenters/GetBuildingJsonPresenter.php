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
    /**
     * @param  GetBuildingResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
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

    /**
     * @param  GetBuildingResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function noSuchBuilding(GetBuildingResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    NoSuchBuildingResource::class, ['building' => $response->getBuilding()]),
                'statusCode' => 404,
            ]
        );
    }
}
