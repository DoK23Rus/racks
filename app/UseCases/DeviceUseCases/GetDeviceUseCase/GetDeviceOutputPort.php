<?php

namespace App\UseCases\DeviceUseCases\GetDeviceUseCase;

use App\Domain\Interfaces\ViewModel;

interface GetDeviceOutputPort
{
    /**
     * @param  GetDeviceResponseModel  $response
     * @return ViewModel
     */
    public function retrieveDevice(GetDeviceResponseModel $response): ViewModel;

    /**
     * @param  GetDeviceResponseModel  $response
     * @return ViewModel
     */
    public function noSuchDevice(GetDeviceResponseModel $response): ViewModel;
}
