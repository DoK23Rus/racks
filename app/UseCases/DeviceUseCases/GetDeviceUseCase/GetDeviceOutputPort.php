<?php

namespace App\UseCases\DeviceUseCases\GetDeviceUseCase;

use App\Domain\Interfaces\ViewModel;

interface GetDeviceOutputPort
{
    public function retrieveDevice(GetDeviceResponseModel $response): ViewModel;

    public function noSuchDevice(GetDeviceResponseModel $response): ViewModel;
}
