<?php

namespace App\Adapters\Presenters\RoomPresenters;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Domain\Interfaces\ViewModel;
use App\Http\Resources\RoomResources\NoSuchRoomResource;
use App\Http\Resources\RoomResources\PermissionExceptionResource;
use App\Http\Resources\RoomResources\RoomNameExceptionResource;
use App\Http\Resources\RoomResources\RoomUpdatedResource;
use App\Http\Resources\RoomResources\UnableToUpdateRoomResource;
use App\UseCases\RoomUseCases\UpdateRoomUseCase\UpdateRoomOutputPort;
use App\UseCases\RoomUseCases\UpdateRoomUseCase\UpdateRoomResponseModel;

class UpdateRoomJsonPresenter implements UpdateRoomOutputPort
{
    /**
     * @param  UpdateRoomResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function roomUpdated(UpdateRoomResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    RoomUpdatedResource::class, ['room' => $response->getRoom()]),
                'statusCode' => 202,
            ]
        );
    }

    /**
     * @param  UpdateRoomResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function noSuchRoom(UpdateRoomResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    NoSuchRoomResource::class, ['room' => $response->getRoom()]),
                'statusCode' => 404,
            ]
        );
    }

    /**
     * @param  UpdateRoomResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function roomNameException(UpdateRoomResponseModel $response): ViewModel
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
     * @param  UpdateRoomResponseModel  $response
     * @param  \Throwable  $e
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Throwable
     */
    public function unableToUpdateRoom(UpdateRoomResponseModel $response, \Throwable $e): ViewModel
    {
        if (config('app.debug')) {
            throw $e;
        }

        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    UnableToUpdateRoomResource::class, ['e' => $e]),
                'statusCode' => 500,
            ]
        );
    }

    /**
     * @param  UpdateRoomResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function permissionException(UpdateRoomResponseModel $response): ViewModel
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
