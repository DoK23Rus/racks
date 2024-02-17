<?php

namespace App\Domain\Interfaces\RackInterfaces;

use App\Models\Rack;
use App\Models\ValueObjects\RackAttributesValueObject;
use App\Models\ValueObjects\RackBusyUnitsValueObject;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Rack entity
 *
 * Rack or cabinet with devices
 * For properties @see Rack
 */
interface RackEntity
{
    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @param  int  $id
     * @return void
     */
    public function setId(int $id): void;

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
     * @return int|null
     */
    public function getAmount(): ?int;

    /**
     * @param  int|null  $amount
     * @return void
     */
    public function setAmount(?int $amount): void;

    /**
     * @return string|null
     */
    public function getVendor(): ?string;

    /**
     * @param  string|null  $vendor
     * @return void
     */
    public function setVendor(?string $vendor): void;

    /**
     * @return string|null
     */
    public function getModel(): ?string;

    /**
     * @param  string|null  $description
     * @return void
     */
    public function setDescription(?string $description): void;

    /**
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * @return bool|null
     */
    public function getHasNumberingFromTopToBottom(): ?bool;

    /**
     * @param  bool|null  $hasNumberingFromTopToBottom
     * @return void
     */
    public function setHasNumberingFromTopToBottom(?bool $hasNumberingFromTopToBottom): void;

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
     * @return string|null
     */
    public function getFinanciallyResponsiblePerson(): ?string;

    /**
     * @param  string|null  $financiallyResponsiblePerson
     * @return void
     */
    public function setFinanciallyResponsiblePerson(?string $financiallyResponsiblePerson): void;

    /**
     * @return string|null
     */
    public function getInventoryNumber(): ?string;

    /**
     * @param  string|null  $inventoryNumber
     * @return void
     */
    public function setInventoryNumber(?string $inventoryNumber): void;

    /**
     * @return string|null
     */
    public function getFixedAsset(): ?string;

    /**
     * @param  string|null  $fixedAsset
     * @return void
     */
    public function setFixedAsset(?string $fixedAsset): void;

    /**
     * @return string|null
     */
    public function getLinkToDocs(): ?string;

    /**
     * @param  string|null  $linkToDocs
     * @return void
     */
    public function setLinkToDocs(?string $linkToDocs): void;

    /**
     * @return string|null
     */
    public function getRow(): ?string;

    /**
     * @param  string|null  $row
     * @return void
     */
    public function setRow(?string $row): void;

    /**
     * @return string|null
     */
    public function getPlace(): ?string;

    /**
     * @param  string|null  $place
     * @return void
     */
    public function setPlace(?string $place): void;

    /**
     * @return int|null
     */
    public function getHeight(): ?int;

    /**
     * @param  int|null  $height
     * @return void
     */
    public function setHeight(?int $height): void;

    /**
     * @return int|null
     */
    public function getWidth(): ?int;

    /**
     * @param  int|null  $width
     * @return void
     */
    public function setWidth(?int $width): void;

    /**
     * @return int|null
     */
    public function getDepth(): ?int;

    /**
     * @param  int|null  $depth
     * @return void
     */
    public function setDepth(?int $depth): void;

    /**
     * @return int|null
     */
    public function getUnitWidth(): ?int;

    /**
     * @param  int|null  $unitWidth
     * @return void
     */
    public function setUnitWidth(?int $unitWidth): void;

    /**
     * @return int|null
     */
    public function getUnitDepth(): ?int;

    /**
     * @param  int|null  $unitDepth
     * @return void
     */
    public function setUnitDepth(?int $unitDepth): void;

    /**
     * @return string|null
     */
    public function getType(): ?string;

    /**
     * @param  string|null  $type
     * @return void
     */
    public function setType(?string $type): void;

    /**
     * @return string|null
     */
    public function getFrame(): ?string;

    /**
     * @param  string|null  $frame
     * @return void
     */
    public function setFrame(?string $frame): void;

    /**
     * @return string|null
     */
    public function getPlaceType(): ?string;

    /**
     * @param  string|null  $placeType
     * @return void
     */
    public function setPlaceType(?string $placeType): void;

    /**
     * @return int|null
     */
    public function getMaxLoad(): ?int;

    /**
     * @param  int|null  $maxLoad
     * @return void
     */
    public function setMaxLoad(?int $maxLoad): void;

    /**
     * @return int|null
     */
    public function getPowerSockets(): ?int;

    /**
     * @param  int|null  $powerSockets
     * @return void
     */
    public function setPowerSockets(?int $powerSockets): void;

    /**
     * @return int|null
     */
    public function getPowerSocketsUps(): ?int;

    /**
     * @param  int|null  $powerSocketsUps
     * @return void
     */
    public function setPowerSocketsUps(?int $powerSocketsUps): void;

    /**
     * @return bool|null
     */
    public function getHasExternalUps(): ?bool;

    /**
     * @param  bool|null  $hasExternalUps
     * @return void
     */
    public function setHasExternalUps(?bool $hasExternalUps): void;

    /**
     * @return bool|null
     */
    public function getHasCooler(): ?bool;

    /**
     * @param  bool|null  $hasCooler
     * @return void
     */
    public function setHasCooler(?bool $hasCooler): void;

    /**
     * @return int|null
     */
    public function getRoomId(): ?int;

    /**
     * @param  int|null  $roomId
     * @return void
     */
    public function setRoomId(?int $roomId): void;

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
     * @return BelongsTo
     */
    public function room(): BelongsTo;

    /**
     * @return RackBusyUnitsValueObject
     */
    public function getBusyUnits(): RackBusyUnitsValueObject;

    /**
     * @param  RackBusyUnitsValueObject  $busyUnits
     * @return void
     */
    public function setBusyUnits(RackBusyUnitsValueObject $busyUnits): void;

    /**
     * @return RackAttributesValueObject
     */
    public function getAttributeSet(): RackAttributesValueObject;

    /**
     * @return string
     */
    public function getCreatedAt(): string;

    /**
     * @return string
     */
    public function getUpdatedAt(): string;

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
     * @param  string|null  $oldName
     * @return void
     */
    public function setOldName(?string $oldName): void;

    /**
     * @return string|null
     */
    public function getOldName(): ?string;

    /**
     * @return array<mixed>
     */
    public function toArray(): array;
}
