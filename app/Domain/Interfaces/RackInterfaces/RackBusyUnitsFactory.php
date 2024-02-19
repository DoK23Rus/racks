<?php

namespace App\Domain\Interfaces\RackInterfaces;

interface RackBusyUnitsFactory
{
    /**
     * @param  array<mixed>  $attributes
     * @return RackBusyUnitsInterface
     */
    public function make(array $attributes = []): RackBusyUnitsInterface;
}
