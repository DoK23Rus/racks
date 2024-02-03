<?php

namespace App\UseCases\DeviceUseCases\GetDeviceUseCase;

use App\Domain\Interfaces\ViewModel;

interface GetDeviceInputPort
{
    public function getDevice(GetDeviceRequestModel $request): ViewModel;
}
