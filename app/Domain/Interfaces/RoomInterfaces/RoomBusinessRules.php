<?php

namespace App\Domain\Interfaces\RoomInterfaces;

/**
 * Business rules for Room entity
 */
interface RoomBusinessRules
{
    /**
     * Room names should not be repeated for one building (but may be repeated throughout the system)
     * A room can have either a strictly specific name or a generalized functional one.
     * In this case, the name of the room can be repeated throughout the entire project
     * but should not be repeated within the same building.
     *
     * Takes as arguments list of room names for this building, checks that it is not on the list, returns bool
     *
     * @param  array<string>  $namesList  Room names list for building
     * @return bool
     */
    public function isNameValid(array $namesList): bool;

    /**
     * Check that room name changed (for update)
     * When updating information about a room, it is necessary to take into account
     * that the name should not be repeated within the same building.
     * In this case, the post request should not be blocked due to repetition of the same name.
     *
     * Takes as arguments old room name, checks that it is not the same as old, returns bool
     *
     * @param  string  $roomOldName
     * @return bool
     */
    public function isNameChanging(string $roomOldName): bool;
}
