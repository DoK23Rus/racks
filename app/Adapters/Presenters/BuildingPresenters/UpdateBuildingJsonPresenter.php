<?php

namespace App\Adapters\Presenters\BuildingPresenters;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Domain\Interfaces\ViewModel;
use App\Http\Resources\BuildingResources\BuildingNameExceptionResource;
use App\Http\Resources\BuildingResources\BuildingUpdatedResource;
use App\Http\Resources\BuildingResources\NoSuchBuildingResource;
use App\Http\Resources\BuildingResources\PermissionExceptionResource;
use App\Http\Resources\BuildingResources\UnableToUpdateBuildingResource;
use App\UseCases\BuildingUseCases\UpdateBuildingUseCase\UpdateBuildingOutputPort;
use App\UseCases\BuildingUseCases\UpdateBuildingUseCase\UpdateBuildingResponseModel;

class UpdateBuildingJsonPresenter implements UpdateBuildingOutputPort
{
    /**
     * @param  UpdateBuildingResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function buildingUpdated(UpdateBuildingResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    BuildingUpdatedResource::class, ['building' => $response->getBuilding()]),
                'statusCode' => 202,
            ]
        );
    }

    /**
     * @param  UpdateBuildingResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function noSuchBuilding(UpdateBuildingResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    NoSuchBuildingResource::class, ['building' => $response->getBuilding()]),
                'statusCode' => 404,
            ]
        );
    }

    /**
     * @param  UpdateBuildingResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function buildingNameException(UpdateBuildingResponseModel $response): ViewModel
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
     * @param  UpdateBuildingResponseModel  $response
     * @param  \Throwable  $e
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Throwable
     */
    public function unableToUpdateBuilding(UpdateBuildingResponseModel $response, \Throwable $e): ViewModel
    {
        if (config('app.debug')) {
            throw $e;
        }

        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    UnableToUpdateBuildingResource::class, ['e' => $e]),
                'statusCode' => 500,
            ]
        );
    }

    /**
     * @param  UpdateBuildingResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function permissionException(UpdateBuildingResponseModel $response): ViewModel
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
