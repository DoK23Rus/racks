<?php

namespace App\Adapters\Presenters\DevicePresenters;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Domain\Interfaces\ViewModel;
use App\Http\Resources\DeviceResources\DeviceCreatedResource;
use App\Http\Resources\DeviceResources\DeviceCreationFailedResource;
use App\Http\Resources\DeviceResources\NoSuchRackResource;
use App\Http\Resources\DeviceResources\NoSuchUnitsResource;
use App\Http\Resources\DeviceResources\PermissionExceptionResource;
use App\Http\Resources\DeviceResources\UnableToCreateDeviceResource;
use App\Http\Resources\DeviceResources\UnitsAreBusyResource;
use App\UseCases\DeviceUseCases\CreateDeviceUseCase\CreateDeviceOutputPort;
use App\UseCases\DeviceUseCases\CreateDeviceUseCase\CreateDeviceResponseModel;

class CreateDeviceJsonPresenter implements CreateDeviceOutputPort
{
    /**
     * @param  CreateDeviceResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function deviceCreated(CreateDeviceResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    DeviceCreatedResource::class, ['device' => $response->getDevice()]),
                'statusCode' => 201,
            ]
        );
    }

    /**
     * @param  CreateDeviceResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function noSuchUnits(CreateDeviceResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(NoSuchUnitsResource::class, ['device' => $response->getDevice()]),
                'statusCode' => 400,
            ]
        );
    }

    /**
     * @param  CreateDeviceResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function unitsAreBusy(CreateDeviceResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    UnitsAreBusyResource::class, ['device' => $response->getDevice()]),
                'statusCode' => 400,
            ]
        );
    }

    /**
     * @param  CreateDeviceResponseModel  $response
     * @param  \Throwable  $e
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Throwable
     */
    public function creationFailed(CreateDeviceResponseModel $response, \Throwable $e): ViewModel
    {
        if (config('app.debug')) {
            throw $e;
        }

        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(DeviceCreationFailedResource::class, ['e' => $e]),
                'statusCode' => 500,
            ]
        );
    }

    /**
     * @param  CreateDeviceResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function noSuchRack(CreateDeviceResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(NoSuchRackResource::class, ['device' => $response->getDevice()]),
                'statusCode' => 400,
            ]
        );
    }

    /**
     * @param  CreateDeviceResponseModel  $response
     * @param  \Throwable  $e
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Throwable
     */
    public function unableToCreateDevice(CreateDeviceResponseModel $response, \Throwable $e): ViewModel
    {
        if (config('app.debug')) {
            throw $e;
        }

        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    UnableToCreateDeviceResource::class, ['e' => $e]),
                'statusCode' => 500,
            ]
        );
    }

    /**
     * @param  CreateDeviceResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function permissionException(CreateDeviceResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    PermissionExceptionResource::class, ['device' => $response->getDevice()]),
                'statusCode' => 403,
            ]
        );
    }
}
