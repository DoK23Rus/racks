<?php

namespace App\Domain\Interfaces\DeviceInterfaces;

use App\Models\ValueObjects\DeviceUnitsValueObject;

interface DeviceUnitsFactory
{
    /**
     * @param  array<int>  $attributes
     * @return DeviceUnitsValueObject
     */
    public function make(array $attributes = []): DeviceUnitsValueObject;
}
