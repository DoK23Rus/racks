<?php

namespace App\Domain\Interfaces\BuildingInterfaces;

use App\Models\Building;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Building entity
 *
 * Building as a location for rooms with racks
 * For properties @see Building
 */
interface BuildingEntity
{
    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param  string  $name
     * @return void
     */
    public function setName(string $name): void;

    /**
     * @return int
     */
    public function getSiteId(): int;

    /**
     * @param  int  $siteId
     * @return void
     */
    public function setSiteId(int $siteId): void;

    /**
     * @return int
     */
    public function getDepartmentId(): int;

    /**
     * @param  int  $departmentId
     * @return void
     */
    public function setDepartmentId(int $departmentId): void;

    /**
     * @param  string  $updatedBy
     * @return void
     */
    public function setUpdatedBy(string $updatedBy): void;

    /**
     * @return string
     */
    public function getUpdatedBy(): string;

    /**
     * @return string
     */
    public function getCreatedAt(): string;

    /**
     * @return string
     */
    public function getUpdatedAt(): string;

    /**
     * @return array<mixed>
     */
    public function toArray(): array;

    /**
     * @return BelongsTo
     */
    public function site(): BelongsTo;

    /**
     * @return HasMany
     */
    public function children(): HasMany;
}
