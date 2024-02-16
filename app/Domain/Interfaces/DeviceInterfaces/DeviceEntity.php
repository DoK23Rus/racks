<?php

namespace App\Domain\Interfaces\DeviceInterfaces;

use App\Models\ValueObjects\DeviceAttributesValueObject;
use App\Models\ValueObjects\DeviceUnitsValueObject;
use Illuminate\Database\Eloquent\Model;

interface DeviceEntity
{
    public function getId(): ?int;

    public function getVendor(): ?string;

    public function setVendor(?string $vendor): void;

    public function getModel(): ?string;

    public function setModel(?string $model): void;

    public function getType(): ?string;

    public function setType(?string $type): void;

    public function getStatus(): ?string;

    public function setStatus(?string $status): void;

    public function getHostname(): ?string;

    public function setHostname(?string $hostname): void;

    public function getIp(): ?string;

    public function setIp(?string $ip): void;

    public function getStack(): ?int;

    public function setStack(?int $stack): void;

    public function getPortsAmount(): ?int;

    public function setPortsAmount(?int $portsAmount): void;

    public function getSoftwareVersion(): ?string;

    public function setSoftwareVersion(?string $softwareVersion): void;

    public function getPowerType(): ?string;

    public function setPowerType(?string $powerType): void;

    public function getPowerW(): ?int;

    public function setPowerW(?int $powerW): void;

    public function getPowerV(): ?int;

    public function setPowerV(?int $powerV): void;

    public function getPowerACDC(): ?string;

    public function setPowerACDC(?string $powerACDC): void;

    public function getSerialNumber(): ?string;

    public function setSerialNumber(?string $serialNumber): void;

    public function getDescription(): ?string;

    public function setDescription(?string $description): void;

    public function getProject(): ?string;

    public function setProject(?string $project): void;

    public function getOwnership(): ?string;

    public function setOwnership(?string $ownership): void;

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

    public function getUnits(): DeviceUnitsValueObject;

    public function setUnits(DeviceUnitsValueObject $units): void;

    public function getRackId(): ?int;

    public function setRackId(?int $rackId): void;

    public function getDepartmentId(): ?int;

    public function setDepartmentId(?int $departmentId): void;

    public function getLocation(): ?bool;

    public function setLocation(?bool $location): void;

    public function getAttributeSet(): DeviceAttributesValueObject;

    public function getUpdatedBy(): string;

    public function setUpdatedBy(string $updatedBy): void;

    public function getCreatedAt(): string;

    public function getUpdatedAt(): string;

    /**
     * @param  array<mixed>|string  $with  Reload param
     * @return Model|null ?Model
     */
    public function fresh(array|string $with): ?Model;

    /**
     * @return array<mixed>
     */
    public function toArray(): array;
}
