<?php

namespace App\Adapters\Presenters\DevicePresenters;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Domain\Interfaces\ViewModel;
use App\Http\Resources\DeviceResources\NoSuchDeviceResource;
use App\Http\Resources\DeviceResources\RetrieveDeviceResource;
use App\UseCases\DeviceUseCases\GetDeviceUseCase\GetDeviceOutputPort;
use App\UseCases\DeviceUseCases\GetDeviceUseCase\GetDeviceResponseModel;

class GetDeviceJsonPresenter implements GetDeviceOutputPort
{
    /**
     * @param  GetDeviceResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function retrieveDevice(GetDeviceResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    RetrieveDeviceResource::class, ['device' => $response->getDevice()]),
                'statusCode' => 200,
            ]
        );
    }

    /**
     * @param  GetDeviceResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function noSuchDevice(GetDeviceResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    NoSuchDeviceResource::class, ['device' => $response->getDevice()]),
                'statusCode' => 404,
            ]
        );
    }
}
