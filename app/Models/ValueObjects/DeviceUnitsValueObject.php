<?php

namespace App\Models\ValueObjects;

use App\Domain\Interfaces\DeviceInterfaces\DeviceUnitsInterface;

class DeviceUnitsValueObject implements DeviceUnitsInterface
{
    /**
     * @var array<int>
     */
    private array $units;

    /**
     * @param  array<int>  $units
     */
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
