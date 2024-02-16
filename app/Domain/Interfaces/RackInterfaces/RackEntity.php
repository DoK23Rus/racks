<?php

namespace App\Domain\Interfaces\RackInterfaces;

use App\Models\ValueObjects\RackAttributesValueObject;
use App\Models\ValueObjects\RackBusyUnitsValueObject;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface RackEntity
{
    public function getId(): int;

    public function setId(int $id): void;

    public function getName(): ?string;

    public function setName(?string $name): void;

    public function getAmount(): ?int;

    public function setAmount(?int $amount): void;

    public function getVendor(): ?string;

    public function setVendor(?string $vendor): void;

    public function getModel(): ?string;

    public function setDescription(?string $description): void;

    public function getDescription(): ?string;

    public function getHasNumberingFromTopToBottom(): ?bool;

    public function setHasNumberingFromTopToBottom(?bool $hasNumberingFromTopToBottom): void;

    public function getResponsible(): ?string;

    public function setResponsible(?string $responsible): void;

    public function getFinanciallyResponsiblePerson(): ?string;

    public function setFinanciallyResponsiblePerson(?string $financiallyResponsiblePerson): void;

    public function getInventoryNumber(): ?string;

    public function setInventoryNumber(?string $inventoryNumber): void;

    public function getFixedAsset(): ?string;

    public function setFixedAsset(?string $fixedAsset): void;

    public function getLinkToDocs(): ?string;

    public function setLinkToDocs(?string $linkToDocs): void;

    public function getRow(): ?string;

    public function setRow(?string $row): void;

    public function getPlace(): ?string;

    public function setPlace(?string $place): void;

    public function getHeight(): ?int;

    public function setHeight(?int $height): void;

    public function getWidth(): ?int;

    public function setWidth(?int $width): void;

    public function getDepth(): ?int;

    public function setDepth(?int $depth): void;

    public function getUnitWidth(): ?int;

    public function setUnitWidth(?int $unitWidth): void;

    public function getUnitDepth(): ?int;

    public function setUnitDepth(?int $unitDepth): void;

    public function getType(): ?string;

    public function setType(?string $type): void;

    public function getFrame(): ?string;

    public function setFrame(?string $frame): void;

    public function getPlaceType(): ?string;

    public function setPlaceType(?string $placeType): void;

    public function getMaxLoad(): ?int;

    public function setMaxLoad(?int $maxLoad): void;

    public function getPowerSockets(): ?int;

    public function setPowerSockets(?int $powerSockets): void;

    public function getPowerSocketsUps(): ?int;

    public function setPowerSocketsUps(?int $powerSocketsUps): void;

    public function getHasExternalUps(): ?bool;

    public function setHasExternalUps(?bool $hasExternalUps): void;

    public function getHasCooler(): ?bool;

    public function setHasCooler(?bool $hasCooler): void;

    public function getRoomId(): ?int;

    public function setRoomId(?int $roomId): void;

    public function getDepartmentId(): ?int;

    public function setDepartmentId(?int $departmentId): void;

    public function room(): BelongsTo;

    public function getBusyUnits(): RackBusyUnitsValueObject;

    public function setBusyUnits(RackBusyUnitsValueObject $busyUnits): void;

    public function getAttributeSet(): RackAttributesValueObject;

    public function getCreatedAt(): string;

    public function getUpdatedAt(): string;

    public function getUpdatedBy(): ?string;

    public function setUpdatedBy(?string $updatedBy): void;

    public function setOldName(?string $oldName): void;

    public function getOldName(): ?string;

    /**
     * @return array<mixed>
     */
    public function toArray(): array;
}
