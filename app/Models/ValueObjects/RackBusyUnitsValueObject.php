<?php

namespace App\Models\ValueObjects;

use App\Domain\Interfaces\RackInterfaces\RackBusyUnitsInterface;

/**
 * Value object for rack busy units data
 */
class RackBusyUnitsValueObject implements RackBusyUnitsInterface
{
    /**
     * @var array{
     *      front: array<int>,
     *      back: array<int>
     *  }
     */
    private array $busyUnits;

    /**
     * @var array<int>
     */
    private array $front;

    /**
     * @var array<int>
     */
    private array $back;

    /**
     * @param  array{
     *     front: array<int>,
     *     back: array<int>
     * }  $busyUnits Busy units array
     */
    public function __construct(array $busyUnits)
    {
        $this->busyUnits = $busyUnits;
        $this->setFront();
        $this->setBack();
    }

    /**
     * @return array{
     *      front: array<int>,
     *      back: array<int>
     *  }
     */
    public function getBusyUnits(): array
    {
        return $this->busyUnits;
    }

    /**
     * @param  bool  $side
     * @return int[]
     */
    public function getArray(bool $side): array
    {
        if (! $side) {
            return $this->front;
        }

        return $this->back;
    }

    /**
     * @return void
     */
    public function setFront(): void
    {
        if (! array_key_exists('front', $this->busyUnits)) {
            $this->busyUnits['front'] = [];
        }
        $front = $this->busyUnits['front'];
        sort($front);
        $this->front = $front;
    }

    /**
     * @return void
     */
    public function setBack(): void
    {
        if (! array_key_exists('back', $this->busyUnits)) {
            $this->busyUnits['back'] = [];
        }
        $back = $this->busyUnits['back'];
        sort($back);
        $this->back = $back;
    }
}
