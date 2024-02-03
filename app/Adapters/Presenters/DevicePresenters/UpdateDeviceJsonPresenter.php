<?php

namespace App\Adapters\Presenters\DevicePresenters;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Domain\Interfaces\ViewModel;
use App\Http\Resources\DeviceResources\DeviceUpdatedResource;
use App\Http\Resources\DeviceResources\DeviceUpdateFailedResource;
use App\Http\Resources\DeviceResources\NoSuchDeviceResource;
use App\Http\Resources\DeviceResources\NoSuchUnitsResource;
use App\Http\Resources\DeviceResources\PermissionExceptionResource;
use App\Http\Resources\DeviceResources\UnableToUpdateDeviceResource;
use App\Http\Resources\DeviceResources\UnitsAreBusyResource;
use App\UseCases\DeviceUseCases\UpdateDeviceUseCase\UpdateDeviceOutputPort;
use App\UseCases\DeviceUseCases\UpdateDeviceUseCase\UpdateDeviceResponseModel;

class UpdateDeviceJsonPresenter implements UpdateDeviceOutputPort
{
    public function deviceUpdated(UpdateDeviceResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    DeviceUpdatedResource::class, ['device' => $response->getDevice()]),
                'statusCode' => 202,
            ]
        );
    }

    public function noSuchUnits(UpdateDeviceResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    NoSuchUnitsResource::class, ['device' => $response->getDevice()]),
                'statusCode' => 400,
            ]
        );
    }

    public function unitsAreBusy(UpdateDeviceResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    UnitsAreBusyResource::class, ['device' => $response->getDevice()]),
                'statusCode' => 400,
            ]
        );
    }

    public function updateFailed(UpdateDeviceResponseModel $response, \Throwable $e): ViewModel
    {
        if (config('app.debug')) {
            throw $e;
        }

        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    DeviceUpdateFailedResource::class, ['e' => $e]),
                'statusCode' => 500,
            ]
        );
    }

    public function noSuchDevice(UpdateDeviceResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    NoSuchDeviceResource::class, ['device' => $response->getDevice()]),
                'statusCode' => 404,
            ]
        );
    }

    public function unableToUpdateDevice(UpdateDeviceResponseModel $response, \Throwable $e): ViewModel
    {
        if (config('app.debug')) {
            throw $e;
        }

        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    UnableToUpdateDeviceResource::class, ['e' => $e]),
                'statusCode' => 500,
            ]
        );
    }

    public function permissionException(UpdateDeviceResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    PermissionExceptionResource::class, ['building' => $response->getDevice()]),
                'statusCode' => 403,
            ]
        );
    }
}
