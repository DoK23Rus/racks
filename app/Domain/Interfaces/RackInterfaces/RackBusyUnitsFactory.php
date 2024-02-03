<?php

namespace App\Domain\Interfaces\RackInterfaces;

interface RackBusyUnitsFactory
{
    /**
     * @param  array<mixed>  $attributes
     */
    public function make(array $attributes = []): RackBusyUnitsInterface;
}
