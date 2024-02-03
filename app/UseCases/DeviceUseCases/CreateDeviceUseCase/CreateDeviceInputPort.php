<?php

namespace App\UseCases\DeviceUseCases\CreateDeviceUseCase;

use App\Domain\Interfaces\ViewModel;

interface CreateDeviceInputPort
{
    public function createDevice(CreateDeviceRequestModel $request): ViewModel;
}
