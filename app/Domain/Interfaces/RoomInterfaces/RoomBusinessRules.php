<?php

namespace App\Domain\Interfaces\RoomInterfaces;

/**
 * Business rules for Room entity
 */
interface RoomBusinessRules
{
    /**
     * Room names should not be repeated for one building (but may be repeated throughout the system)
     *
     * @param  array<string>  $namesList  Room names list for building
     * @return bool
     */
    public function isNameValid(array $namesList): bool;
}
