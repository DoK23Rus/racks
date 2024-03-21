<?php

namespace App\Models\ValueObjects;

use App\Domain\Interfaces\BuildingInterfaces\BuildingEntity;

/**
 * Value object for building PATCHing (reverse DTO)
 */
class BuildingAttributesValueObject
{
    /**
     * @var array<mixed>
     */
    private array $attributesForBuilding = [];

    /**
     * @var BuildingEntity
     */
    private BuildingEntity $building;

    /**
     * @param  BuildingEntity  $building
     */
    public function __construct(BuildingEntity $building)
    {
        $this->building = $building;
        $this->setName();
        $this->setUpdatedBy();
        $this->setSiteId();
        $this->setDescription();
        $this->setDepartmentId();
    }

    /**
     * @return void
     */
    public function setName(): void
    {
        $name = $this->building->getName();
        if ($name) {
            $this->attributesForBuilding += ['name' => $name];
        }
    }

    /**
     * @return void
     */
    public function setSiteId(): void
    {
        $siteId = $this->building->getSiteId();
        if ($siteId) {
            $this->attributesForBuilding += ['site_id' => $siteId];
        }
    }

    /**
     * @return void
     */
    public function setUpdatedBy(): void
    {
        $updatedBy = $this->building->getUpdatedBy();
        if ($updatedBy) {
            $this->attributesForBuilding += ['updated_by' => $updatedBy];
        }
    }

    /**
     * @return void
     */
    public function setDescription(): void
    {
        $description = $this->building->getDescription();
        if ($description) {
            $this->attributesForBuilding += ['description' => $description];
        }
    }

    /**
     * @return void
     */
    public function setDepartmentId(): void
    {
        $departmentId = $this->building->getDepartmentId();
        if ($departmentId) {
            $this->attributesForBuilding += ['department_id' => $departmentId];
        }
    }

    /**
     * @return array<mixed> Get attributes array
     */
    public function toArray(): array
    {
        return $this->attributesForBuilding;
    }
}
