<?php

namespace App\Domain\Interfaces\RackInterfaces;

interface RackBusyUnitsInterface
{
    public function getArray(bool $side): array;

    public function getBusyUnits(): array;

    public function setFront(): void;

    public function setBack(): void;
}
