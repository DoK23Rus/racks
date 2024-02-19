<?php

namespace App\Domain\Interfaces\RoomInterfaces;

use App\Models\Room;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Room entity
 *
 * Room as a location for racks/cabinets with devices
 * For properties @see Room
 * For business rules @see RoomBusinessRules
 */
interface RoomEntity
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
    public function getBuildingId(): int;

    /**
     * @param  int  $buildingId
     * @return void
     */
    public function setBuildingId(int $buildingId): void;

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
    public function building(): BelongsTo;

    /**
     * @return HasMany
     */
    public function children(): HasMany;
}
