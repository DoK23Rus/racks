<?php

namespace App\Domain\Interfaces\RegionInterfaces;

use Illuminate\Database\Eloquent\Relations\HasMany;

interface RegionEntity
{
    public function getId(): int;

    public function getName(): string;

    public function setName(string $name): void;

    public function getCreatedAt(): string;

    public function getUpdatedAt(): string;

    public function children(): HasMany;
}
