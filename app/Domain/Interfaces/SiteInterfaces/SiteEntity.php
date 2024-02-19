<?php

namespace App\Domain\Interfaces\SiteInterfaces;

use App\Models\Site;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Site entity
 *
 * Site as a location for buildings
 * For properties @see Site
 * For business rules @see SiteBusinessRules
 */
interface SiteEntity
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
    public function getDepartmentId(): int;

    /**
     * @param  int  $departmentId
     * @return void
     */
    public function setDepartmentId(int $departmentId): void;

    /**
     * @return string
     */
    public function getUpdatedBy(): string;

    /**
     * @param  string  $updatedBy
     * @return void
     */
    public function setUpdatedBy(string $updatedBy): void;

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
    public function department(): BelongsTo;

    /**
     * @return HasMany
     */
    public function children(): HasMany;
}
