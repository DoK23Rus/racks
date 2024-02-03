<?php

namespace App\Domain\Interfaces\DeviceInterfaces;

use App\Models\ValueObjects\DeviceUnitsValueObject;

interface DeviceUnitsFactory
{
    /**
     * @param  array<mixed>  $attributes
     */
    public function make(array $attributes = []): DeviceUnitsValueObject;
}
