<?php

namespace App\UseCases\DeviceUseCases\CreateDeviceUseCase;

use App\Domain\Interfaces\DeviceInterfaces\DeviceEntity;

class CreateDeviceResponseModel
{
    public function __construct(
        private readonly DeviceEntity $device
    ) {
    }

    public function getDevice(): DeviceEntity
    {
        return $this->device;
    }
}
