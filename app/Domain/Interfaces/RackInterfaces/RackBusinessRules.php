<?php

namespace App\Domain\Interfaces\RackInterfaces;

use App\Domain\Interfaces\DeviceInterfaces\DeviceEntity;

/**
 * Business rules for Rack entity
 */
interface RackBusinessRules
{
    /**
     * Check that device can be added to rack (units not busy).
     * To install new device in a rack, the intended units must be physically free.
     * For example: device with units 2,3,4 can not be added to rack with busy units 1,2,7,8,9 (one side).
     *
     * @param  DeviceEntity  $device
     * @return bool
     */
    public function isDeviceAddable(DeviceEntity $device): bool;

    /**
     * Check that rack has such units (units range).
     * The range of intended device units must not exceed the range of all possible rack units.
     * For example: device with units 19,20,21 can not be added to rack with 20 units height.
     *
     * @param  DeviceEntity  $device
     * @return bool
     */
    public function hasDeviceUnits(DeviceEntity $device): bool;

    /**
     * Check that device can be moved to another units (can intersect with old device units).
     * When rearranging a device within one rack,
     * you need to take into account the units that the device currently occupies.
     * For example, moving a device occupying several units one unit higher.
     * In this case, the units that the device occupied before the reshuffle will be available to it.
     *
     * @param  DeviceEntity  $device
     * @param  DeviceEntity  $deviceUpdating
     * @return bool
     */
    public function isDeviceMovingValid(DeviceEntity $device, DeviceEntity $deviceUpdating): bool;

    /**
     * Rack names should not be repeated for one room (but may be repeated throughout the system)
     * A rack can have either a strictly specific name or a generalized functional one.
     * In this case, the name of the rack can be repeated throughout the entire project
     * but should not be repeated within the same room.
     *
     * @param  array<string>  $namesList  List of Rack names for this room
     * @return bool Is name valid
     */
    public function isNameValid(array $namesList): bool;

    /**
     * Check that rack name changed (for update)
     * When updating information about a rack, it is necessary to take into account
     * that the name should not be repeated within the same room.
     * In this case, the post request should not be blocked due to repetition of the same name.
     *
     * @param  string  $rackOldName
     * @return bool
     */
    public function isNameChanging(string $rackOldName): bool;

    /**
     * Base update for rack busy units data.
     * Basic method for updating occupied units based on rack side.
     * Takes as an argument the complete updated list of units for one of the sides of the rack.
     *
     * @param  array<int>  $updatedBusyUnitsForSide  Updated units array
     * @param  bool  $side  Rack side (back - true)
     */
    public function updateBusyUnits(array $updatedBusyUnitsForSide, bool $side): void;

    /**
     * Updating rack busy units data by adding new ones (add new device).
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
}
