<?php

namespace App\UseCases\DeviceUseCases\GetDeviceUseCase;

use App\Domain\Interfaces\DeviceInterfaces\DeviceEntity;

class GetDeviceResponseModel
{
    public function __construct(
        private readonly ?DeviceEntity $device
    ) {
    }

    public function getDevice(): ?DeviceEntity
    {
        return $this->device;
    }
}
