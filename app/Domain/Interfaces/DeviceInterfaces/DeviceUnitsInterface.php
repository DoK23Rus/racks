<?php

namespace App\Domain\Interfaces\DeviceInterfaces;

interface DeviceUnitsInterface
{
    /**
     * @return array<int> Units array
     */
    public function toArray(): array;
}
