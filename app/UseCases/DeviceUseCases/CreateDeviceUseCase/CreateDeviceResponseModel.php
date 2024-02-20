<?php

namespace App\UseCases\DeviceUseCases\CreateDeviceUseCase;

use App\Domain\Interfaces\DeviceInterfaces\DeviceEntity;

class CreateDeviceResponseModel
{
    /**
     * @param  DeviceEntity  $device
     */
    public function __construct(
        private readonly DeviceEntity $device
    ) {
    }

    /**
     * @return DeviceEntity
     */
    public function getDevice(): DeviceEntity
    {
        return $this->device;
    }
}
