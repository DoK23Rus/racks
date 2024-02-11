<?php

namespace App\Models\ValueObjects;

use App\Domain\Interfaces\RackInterfaces\RackEntity;

class RackAttributesValueObject
{
    private array $attributesForRack = [];

    private RackEntity $rack;

    public function __construct(RackEntity $rack)
    {
        $this->rack = $rack;
        $this->setVendor();
        $this->setName();
        $this->setUpdatedBy();
        $this->setDepth();
        $this->setDescription();
        $this->setFinanciallyResponsiblePerson();
        $this->setFixedAsset();
        $this->setFrame();
        $this->setHasCooler();
        $this->setHeight();
        $this->setHasExternalUps();
        $this->setInventoryNumber();
        $this->setModel();
        $this->setMaxLoad();
        $this->setHasNumberingFromTopToBottom();
        $this->setLinkToDocs();
        $this->setPlace();
        $this->setPlaceType();
        $this->setPowerSockets();
        $this->setPowerSocketsUps();
        $this->setRow();
        $this->setUnitWidth();
        $this->setUnitDepth();
        $this->setWidth();
        $this->setResponsible();
        $this->setDepartmentId();
        $this->setRoomId();
    }

    public function setName(): void
    {
        $name = $this->rack->getName();
        if ($name) {
            $this->attributesForRack += ['name' => $name];
        }
    }

    public function setVendor(): void
    {
        $vendor = $this->rack->getVendor();
        if ($vendor) {
            $this->attributesForRack += ['vendor' => $vendor];
        }
    }

    public function setUpdatedBy(): void
    {
        $updatedBy = $this->rack->getUpdatedBy();
        if ($updatedBy) {
            $this->attributesForRack += ['updated_by' => $updatedBy];
        }
    }

    public function setModel(): void
    {
        $model = $this->rack->getModel();
        if ($model) {
            $this->attributesForRack += ['model' => $model];
        }
    }

    public function setDescription(): void
    {
        $description = $this->rack->getDescription();
        if ($description) {
            $this->attributesForRack += ['description' => $description];
        }
    }

    public function setHasNumberingFromTopToBottom(): void
    {
        $hasNumberingFromTopToBottom = $this->rack->getHasNumberingFromTopToBottom();
        if (! is_null($hasNumberingFromTopToBottom)) {
            $this->attributesForRack += ['has_numbering_from_top_to_bottom' => $hasNumberingFromTopToBottom];
        }
    }

    public function setResponsible(): void
    {
        $responsible = $this->rack->getResponsible();
        if ($responsible) {
            $this->attributesForRack += ['responsible' => $responsible];
        }
    }

    public function setFinanciallyResponsiblePerson(): void
    {
        $financiallyResponsiblePerson = $this->rack->getFinanciallyResponsiblePerson();
        if ($financiallyResponsiblePerson) {
            $this->attributesForRack += ['financially_responsible_person' => $financiallyResponsiblePerson];
        }
    }

    public function setInventoryNumber(): void
    {
        $inventoryNumber = $this->rack->getInventoryNumber();
        if ($inventoryNumber) {
            $this->attributesForRack += ['inventory_number' => $inventoryNumber];
        }
    }

    public function setFixedAsset(): void
    {
        $fixedAsset = $this->rack->getFixedAsset();
        if ($fixedAsset) {
            $this->attributesForRack += ['fixed_asset' => $fixedAsset];
        }
    }

    public function setLinkToDocs(): void
    {
        $linkToDocs = $this->rack->getLinkToDocs();
        if ($linkToDocs) {
            $this->attributesForRack += ['link_to_docs' => $linkToDocs];
        }
    }

    public function setRow(): void
    {
        $row = $this->rack->getRow();
        if ($row) {
            $this->attributesForRack += ['row' => $row];
        }
    }

    public function setPlace(): void
    {
        $place = $this->rack->getPlace();
        if ($place) {
            $this->attributesForRack += ['place' => $place];
        }
    }

    public function setHeight(): void
    {
        $height = $this->rack->getHeight();
        if ($height) {
            $this->attributesForRack += ['height' => $height];
        }
    }

    public function setWidth(): void
    {
        $width = $this->rack->getWidth();
        if ($width) {
            $this->attributesForRack += ['width' => $width];
        }
    }

    public function setDepth(): void
    {
        $depth = $this->rack->getDepth();
        if ($depth) {
            $this->attributesForRack += ['depth' => $depth];
        }
    }

    public function setUnitWidth(): void
    {
        $unitWidth = $this->rack->getUnitWidth();
        if ($unitWidth) {
            $this->attributesForRack += ['unit_width' => $unitWidth];
        }
    }

    public function setUnitDepth(): void
    {
        $unitDepth = $this->rack->getUnitDepth();
        if ($unitDepth) {
            $this->attributesForRack += ['unit_depth' => $unitDepth];
        }
    }

    public function setType(): void
    {
        $type = $this->rack->getType();
        if ($type) {
            $this->attributesForRack += ['type' => $type];
        }
    }

    public function setFrame(): void
    {
        $frame = $this->rack->getFrame();
        if ($frame) {
            $this->attributesForRack += ['frame' => $frame];
        }
    }

    public function setPlaceType(): void
    {
        $placeType = $this->rack->getPlaceType();
        if ($placeType) {
            $this->attributesForRack += ['place_type' => $placeType];
        }
    }

    public function setMaxLoad(): void
    {
        $maxLoad = $this->rack->getMaxLoad();
        if ($maxLoad) {
            $this->attributesForRack += ['max_load' => $maxLoad];
        }
    }

    public function setPowerSockets(): void
    {
        $powerSockets = $this->rack->getPowerSockets();
        if ($powerSockets) {
            $this->attributesForRack += ['power_sockets' => $powerSockets];
        }
    }

    public function setPowerSocketsUps(): void
    {
        $powerSocketsUps = $this->rack->getPowerSocketsUps();
        if ($powerSocketsUps) {
            $this->attributesForRack += ['power_sockets_ups' => $powerSocketsUps];
        }
    }

    public function setHasExternalUps(): void
    {
        $hasExternalUps = $this->rack->getHasExternalUps();
        if ($hasExternalUps) {
            $this->attributesForRack += ['has_external_ups' => $hasExternalUps];
        }
    }

    public function setHasCooler(): void
    {
        $hasCooler = $this->rack->getHasCooler();
        if ($hasCooler) {
            $this->attributesForRack += ['has_cooler' => $hasCooler];
        }
    }

    public function setDepartmentId(): void
    {
        $departmentId = $this->rack->getDepartmentId();
        if ($departmentId) {
            $this->attributesForRack += ['department_id' => $departmentId];
        }
    }

    public function setRoomId(): void
    {
        $roomId = $this->rack->getRoomId();
        if ($roomId) {
            $this->attributesForRack += ['room_id' => $roomId];
        }
    }

    public function getArray(): array
    {
        return $this->attributesForRack;
    }
}
