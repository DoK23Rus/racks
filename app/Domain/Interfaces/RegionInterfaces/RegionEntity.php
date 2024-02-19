<?php

namespace App\Domain\Interfaces\RegionInterfaces;

use App\Models\Region;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Region entity
 *
 * Region as a location for departments
 * For properties @see Region
 */
interface RegionEntity
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
     * @return string
     */
    public function getCreatedAt(): string;

    /**
     * @return string
     */
    public function getUpdatedAt(): string;

    /**
     * @return HasMany
     */
    public function children(): HasMany;
}
