<?php

namespace App\Domain\Interfaces\RackInterfaces;

interface RackBusyUnitsFactory
{
    /**
     * @param  array{front: array<int>, back: array<int>}|array<null>  $attributes
     * @return RackBusyUnitsInterface
     */
    public function make(array $attributes = []): RackBusyUnitsInterface;
}
