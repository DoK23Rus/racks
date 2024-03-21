<?php

namespace App\UseCases\DeviceUseCases\DeleteDeviceUseCase;

use App\Domain\Interfaces\DeviceInterfaces\DeviceEntity;

class DeleteDeviceResponseModel
{
    /**
     * @param  DeviceEntity|null  $device  Null for no such device response
     */
    public function __construct(
        private readonly ?DeviceEntity $device
    ) {
    }

    /**
     * @return DeviceEntity|null
     */
    public function getDevice(): ?DeviceEntity
    {
        return $this->device;
    }
}
