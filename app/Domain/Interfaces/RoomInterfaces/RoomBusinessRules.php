<?php

namespace App\Domain\Interfaces\RoomInterfaces;

interface RoomBusinessRules
{
    /**
     * @param  array<string>  $namesList  Room names list for building
     * @return bool Is Name valid
     */
    public function isNameValid(array $namesList): bool;
}
