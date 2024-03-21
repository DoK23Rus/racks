<?php

namespace App\Models\ValueObjects;

use App\Domain\Interfaces\DeviceInterfaces\DeviceUnitsInterface;

/**
 * Device units value object
 * Units occupied by the device
 */
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

    /**
     * @return array<int>
     */
    public function toArray(): array
    {
        return $this->units;
    }
}
