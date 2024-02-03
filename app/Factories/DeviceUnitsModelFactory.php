<?php

namespace App\Factories;

use App\Domain\Interfaces\DeviceInterfaces\DeviceUnitsFactory;
use App\Models\ValueObjects\DeviceUnitsValueObject;

class DeviceUnitsModelFactory implements DeviceUnitsFactory
{
    public function make(array $attributes = []): DeviceUnitsValueObject
    {
        return new DeviceUnitsValueObject($attributes);
    }
}
