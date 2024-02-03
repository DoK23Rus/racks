<?php

namespace App\Adapters\Presenters\RackPresenters;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Domain\Interfaces\ViewModel;
use App\Http\Resources\RackResources\NoSuchRoomResource;
use App\Http\Resources\RackResources\PermissionExceptionResource;
use App\Http\Resources\RackResources\RackCreatedResource;
use App\Http\Resources\RackResources\RackNameExceptionResource;
use App\Http\Resources\RackResources\UnableToCreateRackResource;
use App\UseCases\RackUseCases\CreateRackUseCase\CreateRackOutputPort;
use App\UseCases\RackUseCases\CreateRackUseCase\CreateRackResponseModel;

class CreateRackJsonPresenter implements CreateRackOutputPort
{
    public function rackCreated(CreateRackResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    RackCreatedResource::class, ['rack' => $response->getRack()]),
                'statusCode' => 201,
            ]
        );
    }

    public function noSuchRoom(CreateRackResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    NoSuchRoomResource::class, ['rack' => $response->getRack()]),
                'statusCode' => 400,
            ]
        );
    }

    public function rackNameException(CreateRackResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    RackNameExceptionResource::class, ['rack' => $response->getRack()]),
                'statusCode' => 400,
            ]
        );
    }

    public function unableToCreateRack(CreateRackResponseModel $response, \Throwable $e): ViewModel
    {
        if (config('app.debug')) {
            throw $e;
        }

        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    UnableToCreateRackResource::class, ['e' => $e]),
                'statusCode' => 500,
            ]
        );
    }

    public function permissionException(CreateRackResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    PermissionExceptionResource::class, ['building' => $response->getRack()]),
                'statusCode' => 403,
            ]
        );
    }
}
