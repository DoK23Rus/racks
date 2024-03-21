<?php

namespace App\Adapters\Presenters\RoomPresenters;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Domain\Interfaces\ViewModel;
use App\Http\Resources\RoomResources\NoSuchBuildingResource;
use App\Http\Resources\RoomResources\PermissionExceptionResource;
use App\Http\Resources\RoomResources\RoomCreatedResource;
use App\Http\Resources\RoomResources\RoomNameExceptionResource;
use App\Http\Resources\RoomResources\UnableToCreateRoomResource;
use App\UseCases\RoomUseCases\CreateRoomUseCase\CreateRoomOutputPort;
use App\UseCases\RoomUseCases\CreateRoomUseCase\CreateRoomResponseModel;

class CreateRoomJsonPresenter implements CreateRoomOutputPort
{
    /**
     * @param  CreateRoomResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function roomCreated(CreateRoomResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    RoomCreatedResource::class, ['room' => $response->getRoom()]),
                'statusCode' => 201,
            ]
        );
    }

    /**
     * @param  CreateRoomResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function noSuchBuilding(CreateRoomResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    NoSuchBuildingResource::class, ['room' => $response->getRoom()]),
                'statusCode' => 400,
            ]
        );
    }

    /**
     * @param  CreateRoomResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function roomNameException(CreateRoomResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    RoomNameExceptionResource::class, ['room' => $response->getRoom()]),
                'statusCode' => 403,
            ]
        );
    }

    /**
     * @param  CreateRoomResponseModel  $response
     * @param  \Throwable  $e
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Throwable
     */
    public function unableToCreateRoom(CreateRoomResponseModel $response, \Throwable $e): ViewModel
    {
        if (config('app.debug')) {
            throw $e;
        }

        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    UnableToCreateRoomResource::class, ['e' => $e]),
                'statusCode' => 500,
            ]
        );
    }

    /**
     * @param  CreateRoomResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function permissionException(CreateRoomResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    PermissionExceptionResource::class, ['building' => $response->getRoom()]),
                'statusCode' => 403,
            ]
        );
    }
}
