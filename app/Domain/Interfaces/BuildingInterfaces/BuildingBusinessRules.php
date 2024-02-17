<?php

namespace App\Domain\Interfaces\BuildingInterfaces;

/**
 * Business rules for Building entity
 */
interface BuildingBusinessRules
{
    /**
     * Building names should not be repeated for one site (but may be repeated throughout the system)
     *
     * @param  array<string>  $namesList  Array of names
     * @return bool
     */
    public function isNameValid(array $namesList): bool;
}
