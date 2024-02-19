<?php

namespace App\Models\ValueObjects;

use App\Domain\Interfaces\DeviceInterfaces\DeviceEntity;

/**
 * Value object for device PATCHing (reverse DTO)
 */
class DeviceAttributesValueObject
{
    /**
     * @var array<mixed>
     */
    private array $attributesForDevice = [];

    /**
     * @var DeviceEntity
     */
    private DeviceEntity $device;

    /**
     * @param  DeviceEntity  $device
     */
    public function __construct(DeviceEntity $device)
    {
        $this->device = $device;
        $this->setRackId();
        $this->setVendor();
        $this->setModel();
        $this->setUnits();
        $this->setLocation();
        $this->setUpdatedBy();
        $this->setDepartmentId();
        $this->setType();
        $this->setStatus();
        $this->setHostname();
        $this->setIp();
        $this->setPortsAmount();
        $this->setSoftwareVersion();
        $this->setPowerType();
        $this->setPowerW();
        $this->setPowerV();
        $this->setPowerACDC();
        $this->setSerialNumber();
        $this->setDescription();
        $this->setProject();
        $this->setOwnership();
        $this->setResponsible();
        $this->setFinanciallyResponsiblePerson();
        $this->setInventoryNumber();
        $this->setFixedAsset();
        $this->setLinkToDocs();
    }

    /**
     * @return void
     */
    public function setRackId(): void
    {
        $rackId = $this->device->getRackId();
        if ($rackId !== null) {
            $this->attributesForDevice += ['rack_id' => $this->device->getRackId()];
        }
    }

    /**
     * @return void
     */
    public function setUnits(): void
    {
        $units = $this->device->getUnits()->toArray();
        if (count($units)) {
            $this->attributesForDevice += ['units' => json_encode($units)];
        }
    }

    /**
     * @return void
     */
    public function setLocation(): void
    {
        $location = $this->device->getLocation();
        if ($location !== null) {
            $this->attributesForDevice += ['has_backside_location' => $location];
        }
    }

    /**
     * @return void
     */
    public function setModel(): void
    {
        $model = $this->device->getModel();
        if ($model) {
            $this->attributesForDevice += ['model' => $model];
        }
    }

    /**
     * @return void
     */
    public function setVendor(): void
    {
        $vendor = $this->device->getVendor();
        if ($vendor) {
            $this->attributesForDevice += ['vendor' => $vendor];
        }
    }

    /**
     * @return void
     */
    public function setUpdatedBy(): void
    {
        $updatedBy = $this->device->getUpdatedBy();
        if ($updatedBy) {
            $this->attributesForDevice += ['updated_by' => $updatedBy];
        }
    }

    /**
     * @return void
     */
    public function setType(): void
    {
        $type = $this->device->getType();
        if ($type) {
            $this->attributesForDevice += ['type' => $type];
        }
    }

    /**
     * @return void
     */
    public function setStatus(): void
    {
        $status = $this->device->getStatus();
        if ($status) {
            $this->attributesForDevice += ['status' => $status];
        }
    }

    /**
     * @return void
     */
    public function setHostname(): void
    {
        $hostname = $this->device->getHostname();
        if ($hostname) {
            $this->attributesForDevice += ['hostname' => $hostname];
        }
    }

    /**
     * @return void
     */
    public function setIp(): void
    {
        $ip = $this->device->getIp();
        if ($ip) {
            $this->attributesForDevice += ['ip' => $ip];
        }
    }

    /**
     * @return void
     */
    public function setPortsAmount(): void
    {
        $portsAmount = $this->device->getPortsAmount();
        if ($portsAmount) {
            $this->attributesForDevice += ['portsAmount' => $portsAmount];
        }
    }

    /**
     * @return void
     */
    public function setSoftwareVersion(): void
    {
        $softwareVersion = $this->device->getSoftwareVersion();
        if ($softwareVersion) {
            $this->attributesForDevice += ['softwareVersion' => $softwareVersion];
        }
    }

    /**
     * @return void
     */
    public function setPowerType(): void
    {
        $powerType = $this->device->getPowerType();
        if ($powerType) {
            $this->attributesForDevice += ['powerType' => $powerType];
        }
    }

    /**
     * @return void
     */
    public function setPowerW(): void
    {
        $powerW = $this->device->getPowerW();
        if ($powerW) {
            $this->attributesForDevice += ['power_w' => $powerW];
        }
    }

    /**
     * @return void
     */
    public function setPowerV(): void
    {
        $powerV = $this->device->getPowerV();
        if ($powerV) {
            $this->attributesForDevice += ['power_v' => $powerV];
        }
    }

    /**
     * @return void
     */
    public function setPowerACDC(): void
    {
        $powerACDC = $this->device->getPowerACDC();
        if ($powerACDC) {
            $this->attributesForDevice += ['power_ac_dc' => $powerACDC];
        }
    }

    /**
     * @return void
     */
    public function setSerialNumber(): void
    {
        $serialNumber = $this->device->getSerialNumber();
        if ($serialNumber) {
            $this->attributesForDevice += ['serialNumber' => $serialNumber];
        }
    }

    /**
     * @return void
     */
    public function setDescription(): void
    {
        $description = $this->device->getDescription();
        if ($description) {
            $this->attributesForDevice += ['description' => $description];
        }
    }

    /**
     * @return void
     */
    public function setProject(): void
    {
        $project = $this->device->getProject();
        if ($project) {
            $this->attributesForDevice += ['project' => $project];
        }
    }

    /**
     * @return void
     */
    public function setOwnership(): void
    {
        $ownership = $this->device->getOwnership();
        if ($ownership) {
            $this->attributesForDevice += ['ownership' => $ownership];
        }
    }

    /**
     * @return void
     */
    public function setResponsible(): void
    {
        $responsible = $this->device->getResponsible();
        if ($responsible) {
            $this->attributesForDevice += ['responsible' => $responsible];
        }
    }

    /**
     * @return void
     */
    public function setFinanciallyResponsiblePerson(): void
    {
        $financiallyResponsiblePerson = $this->device->getFinanciallyResponsiblePerson();
        if ($financiallyResponsiblePerson) {
            $this->attributesForDevice += ['financially_responsible_person' => $financiallyResponsiblePerson];
        }
    }

    /**
     * @return void
     */
    public function setInventoryNumber(): void
    {
        $inventoryNumber = $this->device->getInventoryNumber();
        if ($inventoryNumber) {
            $this->attributesForDevice += ['inventory_number' => $inventoryNumber];
        }
    }

    /**
     * @return void
     */
    public function setFixedAsset(): void
    {
        $fixedAsset = $this->device->getFixedAsset();
        if ($fixedAsset) {
            $this->attributesForDevice += ['fixed_asset' => $fixedAsset];
        }
    }

    /**
     * @return void
     */
    public function setLinkToDocs(): void
    {
        $linkToDocs = $this->device->getResponsible();
        if ($linkToDocs) {
            $this->attributesForDevice += ['link_to_docs' => $linkToDocs];
        }
    }

    /**
     * @return void
     */
    public function setDepartmentId(): void
    {
        $departmentId = $this->device->getDepartmentId();
        if ($departmentId) {
            $this->attributesForDevice += ['department_id' => $departmentId];
        }
    }

    /**
     * @return array<mixed> Get attributes array
     */
    public function toArray(): array
    {
        return $this->attributesForDevice;
    }
}
