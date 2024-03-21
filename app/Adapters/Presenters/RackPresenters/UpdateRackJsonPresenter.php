<?php

namespace App\Adapters\Presenters\RackPresenters;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Domain\Interfaces\ViewModel;
use App\Http\Resources\RackResources\NoSuchRackResource;
use App\Http\Resources\RackResources\PermissionExceptionResource;
use App\Http\Resources\RackResources\RackNameExceptionResource;
use App\Http\Resources\RackResources\RackUpdatedResource;
use App\Http\Resources\RackResources\UnableToUpdateRackResource;
use App\UseCases\RackUseCases\UpdateRackUseCase\UpdateRackOutputPort;
use App\UseCases\RackUseCases\UpdateRackUseCase\UpdateRackResponseModel;

class UpdateRackJsonPresenter implements UpdateRackOutputPort
{
    /**
     * @param  UpdateRackResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function rackUpdated(UpdateRackResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    RackUpdatedResource::class, ['rack' => $response->getRack()]),
                'statusCode' => 202,
            ]
        );
    }

    /**
     * @param  UpdateRackResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function noSuchRack(UpdateRackResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    NoSuchRackResource::class, ['rack' => $response->getRack()]),
                'statusCode' => 404,
            ]
        );
    }

    /**
     * @param  UpdateRackResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function rackNameException(UpdateRackResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    RackNameExceptionResource::class, ['rack' => $response->getRack()]),
                'statusCode' => 400,
            ]
        );
    }

    /**
     * @param  UpdateRackResponseModel  $response
     * @param  \Throwable  $e
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Throwable
     */
    public function unableToUpdateRack(UpdateRackResponseModel $response, \Throwable $e): ViewModel
    {
        if (config('app.debug')) {
            throw $e;
        }

        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    UnableToUpdateRackResource::class, ['e' => $e]),
                'statusCode' => 500,
            ]
        );
    }

    /**
     * @param  UpdateRackResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function permissionException(UpdateRackResponseModel $response): ViewModel
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
