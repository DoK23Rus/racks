<?php

namespace App\UseCases\DeviceUseCases\UpdateDeviceUseCase;

use App\Domain\Interfaces\DeviceInterfaces\DeviceEntity;

class UpdateDeviceResponseModel
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
