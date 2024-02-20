<?php

namespace App\Domain\Interfaces\DepartmentInterfaces;

use App\Models\Department;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Department entity
 *
 * Department as a location for sites
 * For properties @see Department
 * For business rules @see DepartmentBusinessRules
 */
interface DepartmentEntity
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
    public function getRegionId(): int;

    /**
     * @param  int  $regionId
     * @return void
     */
    public function setRegionId(int $regionId): void;

    /**
     * @return string
     */
    public function getCreatedAt(): string;

    /**
     * @return string
     */
    public function getUpdatedAt(): string;

    /**
     * @return BelongsTo
     */
    public function region(): BelongsTo;

    /**
     * @return HasMany
     */
    public function children(): HasMany;

    /**
     * @return HasMany
     */
    public function users(): HasMany;

    /**
     * @return HasMany
     */
    public function buildings(): HasMany;
}
