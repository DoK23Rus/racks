<?php

namespace App\Domain\Interfaces\BuildingInterfaces;

interface BuildingBusinessRules
{
    /**
     * @param  array<string>  $namesList  Array of names
     */
    public function isNameValid(array $namesList): bool;
}
