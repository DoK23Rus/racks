<?php

namespace App\Domain\Interfaces\RackInterfaces;

use App\Domain\Interfaces\DeviceInterfaces\DeviceEntity;

/**
 * Business rules for Room entity
 */
interface RackBusinessRules
{
    /**
     * Check that device can be added to rack (units not busy)
     *
     * @param  DeviceEntity  $device
     * @return bool
     */
    public function isDeviceAddable(DeviceEntity $device): bool;

    /**
     * Check that rack has such units (units range)
     *
     * @param  DeviceEntity  $device
     * @return bool
     */
    public function hasDeviceUnits(DeviceEntity $device): bool;

    /**
     * Check that device can be moved to another units (can intersect with old device units)
     *
     * @param  DeviceEntity  $device
     * @param  DeviceEntity  $deviceUpdating
     * @return bool
     */
    public function isDeviceMovingValid(DeviceEntity $device, DeviceEntity $deviceUpdating): bool;

    /**
     * Rack names should not be repeated for one room (but may be repeated throughout the system)
     *
     * @param  array<string>  $namesList  List of Rack names for this room
     * @return bool Is name valid
     */
    public function isNameValid(array $namesList): bool;

    /**
     * Check that rack name changed (for update)
     *
     * @param  string  $rackOldName
     * @return bool
     */
    public function isNameChanging(string $rackOldName): bool;

    /**
     * Updating rack busy units data by adding new ones (add new device)
     *
     * @param  array<int>  $newUnits  New units array
     * @param  bool  $side  Rack side (back - true)
     */
    public function addNewBusyUnits(array $newUnits, bool $side): void;

    /**
     * Updating rack busy units data by deleting units (delete device)
     *
     * @param  array<int>  $oldUnits  Old units array
     * @param  bool  $side  Rack side (back - true)
     */
    public function deleteOldBusyUnits(array $oldUnits, bool $side): void;

    /**
     * Base update for rack busy units data
     *
     * @param  array<int>  $updatedBusyUnitsForSide  Updated units array
     * @param  bool  $side  Rack side (back - true)
     */
    public function updateBusyUnits(array $updatedBusyUnitsForSide, bool $side): void;
}
