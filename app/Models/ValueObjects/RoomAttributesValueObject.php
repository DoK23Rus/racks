<?php

namespace App\Models\ValueObjects;

use App\Domain\Interfaces\RoomInterfaces\RoomEntity;

/**
 * Value object for room PATCHing (reverse DTO)
 */
class RoomAttributesValueObject
{
    /**
     * @var array<mixed>
     */
    private array $attributesForRoom = [];

    /**
     * @var RoomEntity
     */
    private RoomEntity $room;

    /**
     * @param  RoomEntity  $room
     */
    public function __construct(RoomEntity $room)
    {
        $this->room = $room;
        $this->setName();
        $this->setUpdatedBy();
        $this->setBuildingId();
        $this->setDescription();
        $this->setDepartmentId();
        $this->setBuildingFloor();
        $this->setNumberOfRackSpaces();
        $this->setArea();
        $this->setCoolingSystem();
        $this->setFireSuppressionSystem();
        $this->setAccessIsOpen();
        $this->setHasRaisedFloor();
        $this->setResponsible();
    }

    /**
     * @return void
     */
    public function setName(): void
    {
        $name = $this->room->getName();
        if ($name) {
            $this->attributesForRoom += ['name' => $name];
        }
    }

    /**
     * @return void
     */
    public function setBuildingFloor(): void
    {
        $buildingFloor = $this->room->getBuildingFloor();
        if ($buildingFloor) {
            $this->attributesForRoom += ['building_floor' => $buildingFloor];
        }
    }

    /**
     * @return void
     */
    public function setBuildingId(): void
    {
        $buildingId = $this->room->getBuildingId();
        if ($buildingId) {
            $this->attributesForRoom += ['building_id' => $buildingId];
        }
    }

    /**
     * @return void
     */
    public function setNumberOfRackSpaces(): void
    {
        $numberOfRackSpaces = $this->room->getNumberOfRackSpaces();
        if ($numberOfRackSpaces) {
            $this->attributesForRoom += ['number_of_rack_spaces' => $numberOfRackSpaces];
        }
    }

    /**
     * @return void
     */
    public function setArea(): void
    {
        $area = $this->room->getArea();
        if ($area) {
            $this->attributesForRoom += ['area' => $area];
        }
    }

    /**
     * @return void
     */
    public function setCoolingSystem(): void
    {
        $coolingSystem = $this->room->getCoolingSystem();
        if ($coolingSystem) {
            $this->attributesForRoom += ['cooling_system' => $coolingSystem];
        }
    }

    /**
     * @return void
     */
    public function setFireSuppressionSystem(): void
    {
        $fireSuppressionSystem = $this->room->getFireSuppressionSystem();
        if ($fireSuppressionSystem) {
            $this->attributesForRoom += ['fire_suppression_system' => $fireSuppressionSystem];
        }
    }

    /**
     * @return void
     */
    public function setAccessIsOpen(): void
    {
        $accessIsOpen = $this->room->getAccessIsOpen();
        if (! is_null($accessIsOpen)) {
            $this->attributesForRoom += ['access_is_open' => $accessIsOpen];
        }
    }

    /**
     * @return void
     */
    public function setHasRaisedFloor(): void
    {
        $hasRaisedFloor = $this->room->getHasRaisedFloor();
        if (! is_null($hasRaisedFloor)) {
            $this->attributesForRoom += ['has_raised_floor' => $hasRaisedFloor];
        }
    }

    /**
     * @return void
     */
    public function setResponsible(): void
    {
        $responsible = $this->room->getResponsible();
        if ($responsible) {
            $this->attributesForRoom += ['responsible' => $responsible];
        }
    }

    /**
     * @return void
     */
    public function setUpdatedBy(): void
    {
        $updatedBy = $this->room->getUpdatedBy();
        if ($updatedBy) {
            $this->attributesForRoom += ['updated_by' => $updatedBy];
        }
    }

    /**
     * @return void
     */
    public function setDescription(): void
    {
        $description = $this->room->getDescription();
        if ($description) {
            $this->attributesForRoom += ['description' => $description];
        }
    }

    /**
     * @return void
     */
    public function setDepartmentId(): void
    {
        $departmentId = $this->room->getDepartmentId();
        if ($departmentId) {
            $this->attributesForRoom += ['department_id' => $departmentId];
        }
    }

    /**
     * @return array<mixed> Get attributes array
     */
    public function toArray(): array
    {
        return $this->attributesForRoom;
    }
}
