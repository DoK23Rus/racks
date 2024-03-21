<?php

namespace App\Adapters\Presenters\RoomPresenters;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Domain\Interfaces\ViewModel;
use App\Http\Resources\RoomResources\NoSuchRoomResource;
use App\Http\Resources\RoomResources\RetrieveRoomResource;
use App\UseCases\RoomUseCases\GetRoomUseCase\GetRoomOutputPort;
use App\UseCases\RoomUseCases\GetRoomUseCase\GetRoomResponseModel;

class GetRoomJsonPresenter implements GetRoomOutputPort
{
    /**
     * @param  GetRoomResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function retrieveRoom(GetRoomResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    RetrieveRoomResource::class, ['room' => $response->getRoom()]),
                'statusCode' => 200,
            ]
        );
    }

    /**
     * @param  GetRoomResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function noSuchRoom(GetRoomResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    NoSuchRoomResource::class, ['room' => $response->getRoom()]),
                'statusCode' => 404,
            ]
        );
    }
}
