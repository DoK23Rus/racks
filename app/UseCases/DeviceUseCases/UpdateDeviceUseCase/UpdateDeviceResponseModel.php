<?php

namespace App\UseCases\DeviceUseCases\UpdateDeviceUseCase;

use App\Domain\Interfaces\DeviceInterfaces\DeviceEntity;

class UpdateDeviceResponseModel
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
