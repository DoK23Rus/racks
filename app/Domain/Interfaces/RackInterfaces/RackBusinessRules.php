<?php

namespace App\Domain\Interfaces\RackInterfaces;

use App\Domain\Interfaces\DeviceInterfaces\DeviceEntity;

interface RackBusinessRules
{
    public function isDeviceAddable(DeviceEntity $device): bool;

    public function hasDeviceUnits(DeviceEntity $device): bool;

    public function isDeviceMovingValid(DeviceEntity $device, DeviceEntity $deviceUpdating): bool;

    /**
     * @param  array<string>  $namesList  List of Rack names for this room
     * @return bool Is name valid
     */
    public function isNameValid(array $namesList): bool;

    public function isNameChanging(string $rackOldName): bool;

    /**
     * @param  array<int>  $newUnits  New units array
     * @param  bool  $side  Rack side (back - true)
     */
    public function addNewBusyUnits(array $newUnits, bool $side): void;

    /**
     * @param  array<int>  $oldUnits  Old units array
     * @param  bool  $side  Rack side (back - true)
     */
    public function deleteOldBusyUnits(array $oldUnits, bool $side): void;

    /**
     * @param  array<int>  $updatedBusyUnitsForSide  Updated units array
     * @param  bool  $side  Rack side (back - true)
     */
    public function updateBusyUnits(array $updatedBusyUnitsForSide, bool $side): void;
}
