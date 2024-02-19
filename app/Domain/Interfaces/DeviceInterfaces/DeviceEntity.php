<?php

namespace App\Domain\Interfaces\DeviceInterfaces;

use App\Models\Device;
use App\Models\ValueObjects\DeviceAttributesValueObject;
use App\Models\ValueObjects\DeviceUnitsValueObject;
use Illuminate\Database\Eloquent\Model;

/**
 * Device entity
 *
 * Device or reserved units
 * For properties @see Device
 * For business rules @see DeviceBusinessRules
 */
interface DeviceEntity
{
    /**
     * @return int|null
     */
    public function getId(): ?int;

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
     * @param  string|null  $model
     * @return void
     */
    public function setModel(?string $model): void;

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
    public function getStatus(): ?string;

    /**
     * @param  string|null  $status
     * @return void
     */
    public function setStatus(?string $status): void;

    /**
     * @return string|null
     */
    public function getHostname(): ?string;

    /**
     * @param  string|null  $hostname
     * @return void
     */
    public function setHostname(?string $hostname): void;

    /**
     * @return string|null
     */
    public function getIp(): ?string;

    /**
     * @param  string|null  $ip
     * @return void
     */
    public function setIp(?string $ip): void;

    /**
     * @return int|null
     */
    public function getStack(): ?int;

    /**
     * @param  int|null  $stack
     * @return void
     */
    public function setStack(?int $stack): void;

    /**
     * @return int|null
     */
    public function getPortsAmount(): ?int;

    /**
     * @param  int|null  $portsAmount
     * @return void
     */
    public function setPortsAmount(?int $portsAmount): void;

    /**
     * @return string|null
     */
    public function getSoftwareVersion(): ?string;

    /**
     * @param  string|null  $softwareVersion
     * @return void
     */
    public function setSoftwareVersion(?string $softwareVersion): void;

    /**
     * @return string|null
     */
    public function getPowerType(): ?string;

    /**
     * @param  string|null  $powerType
     * @return void
     */
    public function setPowerType(?string $powerType): void;

    /**
     * @return int|null
     */
    public function getPowerW(): ?int;

    /**
     * @param  int|null  $powerW
     * @return void
     */
    public function setPowerW(?int $powerW): void;

    /**
     * @return int|null
     */
    public function getPowerV(): ?int;

    /**
     * @param  int|null  $powerV
     * @return void
     */
    public function setPowerV(?int $powerV): void;

    /**
     * @return string|null
     */
    public function getPowerACDC(): ?string;

    /**
     * @param  string|null  $powerACDC
     * @return void
     */
    public function setPowerACDC(?string $powerACDC): void;

    /**
     * @return string|null
     */
    public function getSerialNumber(): ?string;

    /**
     * @param  string|null  $serialNumber
     * @return void
     */
    public function setSerialNumber(?string $serialNumber): void;

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
     * @return string|null
     */
    public function getProject(): ?string;

    /**
     * @param  string|null  $project
     * @return void
     */
    public function setProject(?string $project): void;

    /**
     * @return string|null
     */
    public function getOwnership(): ?string;

    /**
     * @param  string|null  $ownership
     * @return void
     */
    public function setOwnership(?string $ownership): void;

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
     * @return DeviceUnitsValueObject
     */
    public function getUnits(): DeviceUnitsValueObject;

    /**
     * @param  DeviceUnitsValueObject  $units
     * @return void
     */
    public function setUnits(DeviceUnitsValueObject $units): void;

    /**
     * @return int|null
     */
    public function getRackId(): ?int;

    /**
     * @param  int|null  $rackId
     * @return void
     */
    public function setRackId(?int $rackId): void;

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
     * @return bool|null
     */
    public function getLocation(): ?bool;

    /**
     * @param  bool|null  $location
     * @return void
     */
    public function setLocation(?bool $location): void;

    /**
     * @return DeviceAttributesValueObject
     */
    public function getAttributeSet(): DeviceAttributesValueObject;

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
     * @param  array<mixed>|string  $with  Reload param
     * @return Model|null ?Model
     */
    public function fresh(array|string $with): ?Model;

    /**
     * @return array<mixed>
     */
    public function toArray(): array;
}
