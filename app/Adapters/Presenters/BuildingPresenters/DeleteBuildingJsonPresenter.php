<?php

namespace App\Adapters\Presenters\BuildingPresenters;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Domain\Interfaces\ViewModel;
use App\Http\Resources\BuildingResources\BuildingDeletedResource;
use App\Http\Resources\BuildingResources\NoSuchBuildingResource;
use App\Http\Resources\BuildingResources\PermissionExceptionResource;
use App\Http\Resources\BuildingResources\UnableToDeleteBuildingResource;
use App\UseCases\BuildingUseCases\DeleteBuildingUseCase\DeleteBuildingOutputPort;
use App\UseCases\BuildingUseCases\DeleteBuildingUseCase\DeleteBuildingResponseModel;

class DeleteBuildingJsonPresenter implements DeleteBuildingOutputPort
{
    /**
     * @param  DeleteBuildingResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function buildingDeleted(DeleteBuildingResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    BuildingDeletedResource::class, ['building' => $response->getBuilding()]),
                'statusCode' => 204,
            ]
        );
    }

    /**
     * @param  DeleteBuildingResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function noSuchBuilding(DeleteBuildingResponseModel $response): ViewModel
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
     * @param  DeleteBuildingResponseModel  $response
     * @param  \Throwable  $e
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Throwable
     */
    public function unableToDeleteBuilding(DeleteBuildingResponseModel $response, \Throwable $e): ViewModel
    {
        if (config('app.debug')) {
            throw $e;
        }

        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    UnableToDeleteBuildingResource::class, ['e' => $e]),
                'statusCode' => 500,
            ]
        );
    }

    /**
     * @param  DeleteBuildingResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function permissionException(DeleteBuildingResponseModel $response): ViewModel
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
