<?php

namespace App\Models\ValueObjects;

use App\Domain\Interfaces\DeviceInterfaces\DeviceEntity;

class DeviceAttributesValueObject
{
    private array $attributesForDevice = [];

    private DeviceEntity $device;

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

    public function setRackId(): void
    {
        $this->attributesForDevice += ['rack_id' => $this->device->getRackId()];
    }

    public function setUnits(): void
    {
        $units = $this->device->getUnits()->getArray();
        if (count($units)) {
            $this->attributesForDevice += ['units' => json_encode($units)];
        }
    }

    public function setLocation(): void
    {
        $location = $this->device->getLocation();
        if ($location !== null) {
            $this->attributesForDevice += ['has_backside_location' => $location];
        }
    }

    public function setModel(): void
    {
        $model = $this->device->getModel();
        if ($model) {
            $this->attributesForDevice += ['model' => $model];
        }
    }

    public function setVendor(): void
    {
        $vendor = $this->device->getVendor();
        if ($vendor) {
            $this->attributesForDevice += ['vendor' => $vendor];
        }
    }

    public function setUpdatedBy(): void
    {
        $updatedBy = $this->device->getUpdatedBy();
        if ($updatedBy) {
            $this->attributesForDevice += ['updated_by' => $updatedBy];
        }
    }

    public function setType(): void
    {
        $type = $this->device->getType();
        if ($type) {
            $this->attributesForDevice += ['type' => $type];
        }
    }

    public function setStatus(): void
    {
        $status = $this->device->getStatus();
        if ($status) {
            $this->attributesForDevice += ['status' => $status];
        }
    }

    public function setHostname(): void
    {
        $hostname = $this->device->getHostname();
        if ($hostname) {
            $this->attributesForDevice += ['hostname' => $hostname];
        }
    }

    public function setIp(): void
    {
        $ip = $this->device->getIp();
        if ($ip) {
            $this->attributesForDevice += ['ip' => $ip];
        }
    }

    public function setPortsAmount(): void
    {
        $portsAmount = $this->device->getPortsAmount();
        if ($portsAmount) {
            $this->attributesForDevice += ['portsAmount' => $portsAmount];
        }
    }

    public function setSoftwareVersion(): void
    {
        $softwareVersion = $this->device->getSoftwareVersion();
        if ($softwareVersion) {
            $this->attributesForDevice += ['softwareVersion' => $softwareVersion];
        }
    }

    public function setPowerType(): void
    {
        $powerType = $this->device->getPowerType();
        if ($powerType) {
            $this->attributesForDevice += ['powerType' => $powerType];
        }
    }

    public function setPowerW(): void
    {
        $powerW = $this->device->getPowerW();
        if ($powerW) {
            $this->attributesForDevice += ['power_w' => $powerW];
        }
    }

    public function setPowerV(): void
    {
        $powerV = $this->device->getPowerV();
        if ($powerV) {
            $this->attributesForDevice += ['power_v' => $powerV];
        }
    }

    public function setPowerACDC(): void
    {
        $powerACDC = $this->device->getPowerACDC();
        if ($powerACDC) {
            $this->attributesForDevice += ['power_ac_dc' => $powerACDC];
        }
    }

    public function setSerialNumber(): void
    {
        $serialNumber = $this->device->getSerialNumber();
        if ($serialNumber) {
            $this->attributesForDevice += ['serialNumber' => $serialNumber];
        }
    }

    public function setDescription(): void
    {
        $description = $this->device->getDescription();
        if ($description) {
            $this->attributesForDevice += ['description' => $description];
        }
    }

    public function setProject(): void
    {
        $project = $this->device->getProject();
        if ($project) {
            $this->attributesForDevice += ['project' => $project];
        }
    }

    public function setOwnership(): void
    {
        $ownership = $this->device->getOwnership();
        if ($ownership) {
            $this->attributesForDevice += ['ownership' => $ownership];
        }
    }

    public function setResponsible(): void
    {
        $responsible = $this->device->getResponsible();
        if ($responsible) {
            $this->attributesForDevice += ['responsible' => $responsible];
        }
    }

    public function setFinanciallyResponsiblePerson(): void
    {
        $financiallyResponsiblePerson = $this->device->getFinanciallyResponsiblePerson();
        if ($financiallyResponsiblePerson) {
            $this->attributesForDevice += ['financially_responsible_person' => $financiallyResponsiblePerson];
        }
    }

    public function setInventoryNumber(): void
    {
        $inventoryNumber = $this->device->getInventoryNumber();
        if ($inventoryNumber) {
            $this->attributesForDevice += ['inventory_number' => $inventoryNumber];
        }
    }

    public function setFixedAsset(): void
    {
        $fixedAsset = $this->device->getFixedAsset();
        if ($fixedAsset) {
            $this->attributesForDevice += ['fixed_asset' => $fixedAsset];
        }
    }

    public function setLinkToDocs(): void
    {
        $linkToDocs = $this->device->getResponsible();
        if ($linkToDocs) {
            $this->attributesForDevice += ['link_to_docs' => $linkToDocs];
        }
    }

    public function setDepartmentId(): void
    {
        $departmentId = $this->device->getDepartmentId();
        if ($departmentId) {
            $this->attributesForDevice += ['department_id' => $departmentId];
        }
    }

    public function getArray(): array
    {
        return $this->attributesForDevice;
    }
}
