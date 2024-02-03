<?php

namespace App\Adapters\Presenters\DevicePresenters;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Domain\Interfaces\ViewModel;
use App\Http\Resources\DeviceResources\DeviceDeletedResource;
use App\Http\Resources\DeviceResources\DeviceDeletionFailedResource;
use App\Http\Resources\DeviceResources\NoSuchDeviceResource;
use App\Http\Resources\DeviceResources\PermissionExceptionResource;
use App\Http\Resources\DeviceResources\UnableToDeleteDeviceResource;
use App\UseCases\DeviceUseCases\DeleteDeviceUseCase\DeleteDeviceOutputPort;
use App\UseCases\DeviceUseCases\DeleteDeviceUseCase\DeleteDeviceResponseModel;

class DeleteDeviceJsonPresenter implements DeleteDeviceOutputPort
{
    public function deviceDeleted(DeleteDeviceResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    DeviceDeletedResource::class, ['device' => $response->getDevice()]),
                'statusCode' => 204,
            ]
        );
    }

    public function noSuchDevice(DeleteDeviceResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    NoSuchDeviceResource::class, ['device' => $response->getDevice()]),
                'statusCode' => 404,
            ]
        );
    }

    public function deletionFailed(DeleteDeviceResponseModel $response, \Throwable $e): ViewModel
    {
        if (config('app.debug')) {
            throw $e;
        }

        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    DeviceDeletionFailedResource::class, ['e' => $e]),
                'statusCode' => 500,
            ]
        );
    }

    public function unableToDeleteDevice(DeleteDeviceResponseModel $response, \Throwable $e): ViewModel
    {
        if (config('app.debug')) {
            throw $e;
        }

        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    UnableToDeleteDeviceResource::class, ['e' => $e]),
                'statusCode' => 500,
            ]
        );
    }

    public function permissionException(DeleteDeviceResponseModel $response): ViewModel
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
