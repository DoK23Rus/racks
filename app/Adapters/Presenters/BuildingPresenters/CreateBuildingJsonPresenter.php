<?php

namespace App\Adapters\Presenters\BuildingPresenters;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Domain\Interfaces\ViewModel;
use App\Http\Resources\BuildingResources\BuildingCreatedResource;
use App\Http\Resources\BuildingResources\BuildingNameExceptionResource;
use App\Http\Resources\BuildingResources\NoSuchSiteResource;
use App\Http\Resources\BuildingResources\PermissionExceptionResource;
use App\Http\Resources\BuildingResources\UnableToCreateBuildingResource;
use App\UseCases\BuildingUseCases\CreateBuildingUseCase\CreateBuildingOutputPort;
use App\UseCases\BuildingUseCases\CreateBuildingUseCase\CreateBuildingResponseModel;

class CreateBuildingJsonPresenter implements CreateBuildingOutputPort
{
    /**
     * @param  CreateBuildingResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function buildingCreated(CreateBuildingResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    BuildingCreatedResource::class, ['building' => $response->getBuilding()]),
                'statusCode' => 201,
            ]
        );
    }

    /**
     * @param  CreateBuildingResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function noSuchSite(CreateBuildingResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    NoSuchSiteResource::class, ['building' => $response->getBuilding()]),
                'statusCode' => 400,
            ]
        );
    }

    /**
     * @param  CreateBuildingResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function buildingNameException(CreateBuildingResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    BuildingNameExceptionResource::class, ['building' => $response->getBuilding()]),
                'statusCode' => 400,
            ]
        );
    }

    /**
     * @param  CreateBuildingResponseModel  $response
     * @param  \Throwable  $e
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Throwable
     */
    public function unableToCreateBuilding(CreateBuildingResponseModel $response, \Throwable $e): ViewModel
    {
        if (config('app.debug')) {
            throw $e;
        }

        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    UnableToCreateBuildingResource::class, ['e' => $e]),
                'statusCode' => 500,
            ]
        );
    }

    /**
     * @param  CreateBuildingResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function permissionException(CreateBuildingResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    PermissionExceptionResource::class, ['building' => $response->getBuilding()]),
                'statusCode' => 403,
            ]
        );
    }
}
