<?php

namespace App\Models\ValueObjects;

use App\Domain\Interfaces\DeviceInterfaces\DeviceUnitsInterface;

class DeviceUnitsValueObject implements DeviceUnitsInterface
{
    private array $units;

    public function __construct(array $units = [])
    {
        sort($units);
        $this->units = $units;
    }

    public function getArray(): array
    {
        return $this->units;
    }
}
