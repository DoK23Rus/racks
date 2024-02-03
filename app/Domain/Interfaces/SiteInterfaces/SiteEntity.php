<?php

namespace App\Domain\Interfaces\SiteInterfaces;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

interface SiteEntity
{
    public function getId(): int;

    public function getName(): string;

    public function setName(string $name): void;

    public function getDepartmentId(): int;

    public function setDepartmentId(int $departmentId): void;

    public function getUpdatedBy(): string;

    public function setUpdatedBy(string $updatedBy): void;

    public function getCreatedAt(): string;

    public function getUpdatedAt(): string;

    public function toArray(): array;

    public function department(): BelongsTo;

    public function children(): HasMany;
}
