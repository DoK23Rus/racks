<?php

namespace App\Domain\Interfaces\RackInterfaces;

/**
 * Rack busy units
 */
interface RackBusyUnitsInterface
{
    /**
     * @param  bool  $side  Rack side (back - true)
     * @return array<int> Busy units for side
     */
    public function getArray(bool $side): array;

    /**
     * @return array{
     *     front: array<int>,
     *     back: array<int>
     * } Busy units array
     */
    public function getBusyUnits(): array;

    /**
     * @return void
     */
    public function setFront(): void;

    /**
     * @return void
     */
    public function setBack(): void;
}
