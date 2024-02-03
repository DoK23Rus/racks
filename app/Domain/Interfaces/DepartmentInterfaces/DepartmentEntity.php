<?php

namespace App\Domain\Interfaces\DepartmentInterfaces;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

interface DepartmentEntity
{
    public function getId(): int;

    public function getName(): string;

    public function setName(string $name): void;

    public function getRegionId(): int;

    public function setRegionId(int $regionId): void;

    public function getCreatedAt(): string;

    public function getUpdatedAt(): string;

    public function region(): BelongsTo;

    public function children(): HasMany;
}
