<?php

namespace App\Domain\Interfaces\BuildingInterfaces;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

interface BuildingEntity
{
    public function getId(): int;

    public function getName(): string;

    public function setName(string $name): void;

    public function getSiteId(): int;

    public function setSiteId(int $siteId): void;

    public function getDepartmentId(): int;

    public function setDepartmentId(int $departmentId): void;

    public function setUpdatedBy(string $updatedBy): void;

    public function getUpdatedBy(): string;

    public function getCreatedAt(): string;

    public function getUpdatedAt(): string;

    public function toArray(): array;

    public function site(): BelongsTo;

    public function children(): HasMany;
}
