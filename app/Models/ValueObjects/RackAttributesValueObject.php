<?php

namespace App\Models\ValueObjects;

use App\Domain\Interfaces\RackInterfaces\RackEntity;

/**
 * Value object for rack PATCHing (reverse DTO)
 */
class RackAttributesValueObject
{
    /**
     * @var array<mixed>
     */
    private array $attributesForRack = [];

    /**
     * @var RackEntity
     */
    private RackEntity $rack;

    /**
     * @param  RackEntity  $rack
     */
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

    /**
     * @return void
     */
    public function setName(): void
    {
        $name = $this->rack->getName();
        if ($name) {
            $this->attributesForRack += ['name' => $name];
        }
    }

    /**
     * @return void
     */
    public function setVendor(): void
    {
        $vendor = $this->rack->getVendor();
        if ($vendor) {
            $this->attributesForRack += ['vendor' => $vendor];
        }
    }

    /**
     * @return void
     */
    public function setUpdatedBy(): void
    {
        $updatedBy = $this->rack->getUpdatedBy();
        if ($updatedBy) {
            $this->attributesForRack += ['updated_by' => $updatedBy];
        }
    }

    /**
     * @return void
     */
    public function setModel(): void
    {
        $model = $this->rack->getModel();
        if ($model) {
            $this->attributesForRack += ['model' => $model];
        }
    }

    /**
     * @return void
     */
    public function setDescription(): void
    {
        $description = $this->rack->getDescription();
        if ($description) {
            $this->attributesForRack += ['description' => $description];
        }
    }

    /**
     * @return void
     */
    public function setHasNumberingFromTopToBottom(): void
    {
        $hasNumberingFromTopToBottom = $this->rack->getHasNumberingFromTopToBottom();
        if (! is_null($hasNumberingFromTopToBottom)) {
            $this->attributesForRack += ['has_numbering_from_top_to_bottom' => $hasNumberingFromTopToBottom];
        }
    }

    /**
     * @return void
     */
    public function setResponsible(): void
    {
        $responsible = $this->rack->getResponsible();
        if ($responsible) {
            $this->attributesForRack += ['responsible' => $responsible];
        }
    }

    /**
     * @return void
     */
    public function setFinanciallyResponsiblePerson(): void
    {
        $financiallyResponsiblePerson = $this->rack->getFinanciallyResponsiblePerson();
        if ($financiallyResponsiblePerson) {
            $this->attributesForRack += ['financially_responsible_person' => $financiallyResponsiblePerson];
        }
    }

    /**
     * @return void
     */
    public function setInventoryNumber(): void
    {
        $inventoryNumber = $this->rack->getInventoryNumber();
        if ($inventoryNumber) {
            $this->attributesForRack += ['inventory_number' => $inventoryNumber];
        }
    }

    /**
     * @return void
     */
    public function setFixedAsset(): void
    {
        $fixedAsset = $this->rack->getFixedAsset();
        if ($fixedAsset) {
            $this->attributesForRack += ['fixed_asset' => $fixedAsset];
        }
    }

    /**
     * @return void
     */
    public function setLinkToDocs(): void
    {
        $linkToDocs = $this->rack->getLinkToDocs();
        if ($linkToDocs) {
            $this->attributesForRack += ['link_to_docs' => $linkToDocs];
        }
    }

    /**
     * @return void
     */
    public function setRow(): void
    {
        $row = $this->rack->getRow();
        if ($row) {
            $this->attributesForRack += ['row' => $row];
        }
    }

    /**
     * @return void
     */
    public function setPlace(): void
    {
        $place = $this->rack->getPlace();
        if ($place) {
            $this->attributesForRack += ['place' => $place];
        }
    }

    /**
     * @return void
     */
    public function setHeight(): void
    {
        $height = $this->rack->getHeight();
        if ($height) {
            $this->attributesForRack += ['height' => $height];
        }
    }

    /**
     * @return void
     */
    public function setWidth(): void
    {
        $width = $this->rack->getWidth();
        if ($width) {
            $this->attributesForRack += ['width' => $width];
        }
    }

    /**
     * @return void
     */
    public function setDepth(): void
    {
        $depth = $this->rack->getDepth();
        if ($depth) {
            $this->attributesForRack += ['depth' => $depth];
        }
    }

    /**
     * @return void
     */
    public function setUnitWidth(): void
    {
        $unitWidth = $this->rack->getUnitWidth();
        if ($unitWidth) {
            $this->attributesForRack += ['unit_width' => $unitWidth];
        }
    }

    /**
     * @return void
     */
    public function setUnitDepth(): void
    {
        $unitDepth = $this->rack->getUnitDepth();
        if ($unitDepth) {
            $this->attributesForRack += ['unit_depth' => $unitDepth];
        }
    }

    /**
     * @return void
     */
    public function setType(): void
    {
        $type = $this->rack->getType();
        if ($type) {
            $this->attributesForRack += ['type' => $type];
        }
    }

    /**
     * @return void
     */
    public function setFrame(): void
    {
        $frame = $this->rack->getFrame();
        if ($frame) {
            $this->attributesForRack += ['frame' => $frame];
        }
    }

    /**
     * @return void
     */
    public function setPlaceType(): void
    {
        $placeType = $this->rack->getPlaceType();
        if ($placeType) {
            $this->attributesForRack += ['place_type' => $placeType];
        }
    }

    /**
     * @return void
     */
    public function setMaxLoad(): void
    {
        $maxLoad = $this->rack->getMaxLoad();
        if ($maxLoad) {
            $this->attributesForRack += ['max_load' => $maxLoad];
        }
    }

    /**
     * @return void
     */
    public function setPowerSockets(): void
    {
        $powerSockets = $this->rack->getPowerSockets();
        if ($powerSockets) {
            $this->attributesForRack += ['power_sockets' => $powerSockets];
        }
    }

    /**
     * @return void
     */
    public function setPowerSocketsUps(): void
    {
        $powerSocketsUps = $this->rack->getPowerSocketsUps();
        if ($powerSocketsUps) {
            $this->attributesForRack += ['power_sockets_ups' => $powerSocketsUps];
        }
    }

    /**
     * @return void
     */
    public function setHasExternalUps(): void
    {
        $hasExternalUps = $this->rack->getHasExternalUps();
        if ($hasExternalUps) {
            $this->attributesForRack += ['has_external_ups' => $hasExternalUps];
        }
    }

    /**
     * @return void
     */
    public function setHasCooler(): void
    {
        $hasCooler = $this->rack->getHasCooler();
        if ($hasCooler) {
            $this->attributesForRack += ['has_cooler' => $hasCooler];
        }
    }

    /**
     * @return void
     */
    public function setDepartmentId(): void
    {
        $departmentId = $this->rack->getDepartmentId();
        if ($departmentId) {
            $this->attributesForRack += ['department_id' => $departmentId];
        }
    }

    /**
     * @return void
     */
    public function setRoomId(): void
    {
        $roomId = $this->rack->getRoomId();
        if ($roomId) {
            $this->attributesForRack += ['room_id' => $roomId];
        }
    }

    /**
     * @return array<mixed> Get attributes array
     */
    public function getArray(): array
    {
        return $this->attributesForRack;
    }
}
