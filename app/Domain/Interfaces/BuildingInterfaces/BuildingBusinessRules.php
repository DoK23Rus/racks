<?php

namespace App\Domain\Interfaces\BuildingInterfaces;

/**
 * Business rules for Building entity
 */
interface BuildingBusinessRules
{
    /**
     * Building names should not be repeated for one site (but may be repeated throughout the system)
     * A building can have either a strictly specific name or a generalized functional one.
     * In this case, the name of the building can be repeated throughout the entire project
     * but should not be repeated within the same site.
     *
     * Takes as arguments list of building names for this site, checks that it is not on the list, returns bool
     *
     * @param  array<string>  $namesList  Array of names
     * @return bool
     */
    public function isNameValid(array $namesList): bool;

    /**
     * Check that building name changed (for update)
     * When updating information about a building, it is necessary to take into account
     * that the name should not be repeated within the same site.
     * In this case, the post request should not be blocked due to repetition of the same name.
     *
     * Takes as arguments old building name, checks that it is not the same as old, returns bool
     *
     * @param  string  $buildingOldName
     * @return bool
     */
    public function isNameChanging(string $buildingOldName): bool;
}
