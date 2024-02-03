<?php

namespace App\Domain\Interfaces\RoomInterfaces;

interface RoomBusinessRules
{
    public function isNameValid(array $namesList): bool;
}
