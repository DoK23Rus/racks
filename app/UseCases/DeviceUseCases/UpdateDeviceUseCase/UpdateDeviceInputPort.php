<?php

namespace App\UseCases\DeviceUseCases\UpdateDeviceUseCase;

use App\Domain\Interfaces\ViewModel;

interface UpdateDeviceInputPort
{
    public function updateDevice(UpdateDeviceRequestModel $request): ViewModel;
}
