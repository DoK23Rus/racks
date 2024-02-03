<?php

namespace App\Factories;

use App\Domain\Interfaces\RackInterfaces\RackBusyUnitsFactory;
use App\Domain\Interfaces\RackInterfaces\RackBusyUnitsInterface;
use App\Models\ValueObjects\RackBusyUnitsValueObject;

class RackBusyUnitsModelFactory implements RackBusyUnitsFactory
{
    public function make(array $attributes = []): RackBusyUnitsInterface
    {
        return new RackBusyUnitsValueObject($attributes);
    }
}
