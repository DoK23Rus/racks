<?php

namespace App\UseCases\DeviceUseCases\DeleteDeviceUseCase;

use App\Domain\Interfaces\DeviceInterfaces\DeviceEntity;

class DeleteDeviceResponseModel
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
