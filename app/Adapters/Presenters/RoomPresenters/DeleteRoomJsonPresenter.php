<?php

namespace App\Adapters\Presenters\RoomPresenters;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Domain\Interfaces\ViewModel;
use App\Http\Resources\RoomResources\NoSuchRoomResource;
use App\Http\Resources\RoomResources\PermissionExceptionResource;
use App\Http\Resources\RoomResources\RoomDeletedResource;
use App\Http\Resources\RoomResources\UnableToDeleteRoomResource;
use App\UseCases\RoomUseCases\CreateRoomUseCase\CreateRoomResponseModel;
use App\UseCases\RoomUseCases\DeleteRoomUseCase\DeleteRoomOutputPort;
use App\UseCases\RoomUseCases\DeleteRoomUseCase\DeleteRoomResponseModel;

class DeleteRoomJsonPresenter implements DeleteRoomOutputPort
{
    /**
     * @param  DeleteRoomResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function roomDeleted(DeleteRoomResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    RoomDeletedResource::class, ['room' => $response->getRoom()]),
                'statusCode' => 204,
            ]
        );
    }

    /**
     * @param  DeleteRoomResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function noSuchRoom(DeleteRoomResponseModel $response): ViewModel
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
     * @param  DeleteRoomResponseModel  $response
     * @param  \Throwable  $e
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Throwable
     */
    public function unableToDeleteRoom(DeleteRoomResponseModel $response, \Throwable $e): ViewModel
    {
        if (config('app.debug')) {
            throw $e;
        }

        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    UnableToDeleteRoomResource::class, ['e' => $e]),
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
