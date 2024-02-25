<?php

namespace App\Domain\Interfaces\RoomInterfaces;

use App\Models\Room;
use App\Models\ValueObjects\RoomAttributesValueObject;
use Illuminate\Database\Eloquent\Model;
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
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * @param  string|null  $name
     * @return void
     */
    public function setName(?string $name): void;

    /**
     * @return string|null
     */
    public function getBuildingFloor(): ?string;

    /**
     * @param  string|null  $buildingFloor
     * @return void
     */
    public function setBuildingFloor(?string $buildingFloor): void;

    /**
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * @param  string|null  $description
     * @return void
     */
    public function setDescription(?string $description): void;

    /**
     * @return int|null
     */
    public function getNumberOfRackSpaces(): ?int;

    /**
     * @param  int|null  $numberOfRackSpaces
     * @return void
     */
    public function setNumberOfRackSpaces(?int $numberOfRackSpaces): void;

    /**
     * @return int|null
     */
    public function getArea(): ?int;

    /**
     * @param  int|null  $area
     * @return void
     */
    public function setArea(?int $area): void;

    /**
     * @return string|null
     */
    public function getResponsible(): ?string;

    /**
     * @param  string|null  $responsible
     * @return void
     */
    public function setResponsible(?string $responsible): void;

    /**
     * @param  string|null  $coolingSystem
     * @return void
     */
    public function setCoolingSystem(?string $coolingSystem): void;

    /**
     * @return string|null
     */
    public function getCoolingSystem(): ?string;

    /**
     * @return string|null
     */
    public function getFireSuppressionSystem(): ?string;

    /**
     * @param  string|null  $fireSuppressionSystem
     * @return void
     */
    public function setFireSuppressionSystem(?string $fireSuppressionSystem): void;

    /**
     * @return bool|null
     */
    public function getAccessIsOpen(): ?bool;

    /**
     * @param  bool|null  $accessIsOpen
     * @return void
     */
    public function setAccessIsOpen(?bool $accessIsOpen): void;

    /**
     * @return bool|null
     */
    public function getHasRaisedFloor(): ?bool;

    /**
     * @param  bool|null  $hasRaisedFloor
     * @return void
     */
    public function setHasRaisedFloor(?bool $hasRaisedFloor): void;

    /**
     * @return int|null
     */
    public function getBuildingId(): ?int;

    /**
     * @param  int|null  $buildingId
     * @return void
     */
    public function setBuildingId(?int $buildingId): void;

    /**
     * @return int|null
     */
    public function getDepartmentId(): ?int;

    /**
     * @param  int|null  $departmentId
     * @return void
     */
    public function setDepartmentId(?int $departmentId): void;

    /**
     * @return string|null
     */
    public function getUpdatedBy(): ?string;

    /**
     * @param  string|null  $updatedBy
     * @return void
     */
    public function setUpdatedBy(?string $updatedBy): void;

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string;

    /**
     * @param  string|null  $oldName
     * @return void
     */
    public function setOldName(?string $oldName): void;

    /**
     * @return string|null
     */
    public function getOldName(): ?string;

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string;

    /**
     * @return RoomAttributesValueObject
     */
    public function getAttributeSet(): RoomAttributesValueObject;

    /**
     * @return BelongsTo
     */
    public function building(): BelongsTo;

    /**
     * @return BelongsTo
     */
    public function department(): BelongsTo;

    /**
     * @return HasMany
     */
    public function children(): HasMany;

    /**
     * @return array<mixed>
     */
    public function toArray(): array;

    /**
     * @param  array<mixed>|string  $with
     * @return Model|null
     */
    public function fresh($with): ?Model;
}
