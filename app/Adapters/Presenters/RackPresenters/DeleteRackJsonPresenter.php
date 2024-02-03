<?php

namespace App\Adapters\Presenters\RackPresenters;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Domain\Interfaces\ViewModel;
use App\Http\Resources\RackResources\NoSuchRackResource;
use App\Http\Resources\RackResources\PermissionExceptionResource;
use App\Http\Resources\RackResources\RackDeletedResource;
use App\Http\Resources\RackResources\UnableToDeleteRackResource;
use App\UseCases\RackUseCases\DeleteRackUseCase\DeleteRackOutputPort;
use App\UseCases\RackUseCases\DeleteRackUseCase\DeleteRackResponseModel;

class DeleteRackJsonPresenter implements DeleteRackOutputPort
{
    public function rackDeleted(DeleteRackResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    RackDeletedResource::class, ['rack' => $response->getRack()]),
                'statusCode' => 204,
            ]
        );
    }

    public function noSuchRack(DeleteRackResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    NoSuchRackResource::class, ['rack' => $response->getRack()]),
                'statusCode' => 404,
            ]
        );
    }

    public function unableToDeleteRack(DeleteRackResponseModel $response, \Throwable $e): ViewModel
    {
        if (config('app.debug')) {
            throw $e;
        }

        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    UnableToDeleteRackResource::class, ['e' => $e]),
                'statusCode' => 500,
            ]
        );
    }

    public function permissionException(DeleteRackResponseModel $response): ViewModel
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
