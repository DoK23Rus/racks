<?php

namespace App\Domain\Interfaces\BuildingInterfaces;

interface BuildingBusinessRules
{
    public function isNameValid(array $namesList): bool;
}
