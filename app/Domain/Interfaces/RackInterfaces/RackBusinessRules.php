<?php

namespace App\Domain\Interfaces\RackInterfaces;

use App\Domain\Interfaces\DeviceInterfaces\DeviceEntity;

interface RackBusinessRules
{
    public function isDeviceAddable(DeviceEntity $device): bool;

    public function hasDeviceUnits(DeviceEntity $device): bool;

    public function isDeviceMovingValid(DeviceEntity $device, DeviceEntity $deviceUpdating): bool;

    public function isNameValid(array $namesList): bool;

    public function isNameChanging(string $rackOldName): bool;
}
