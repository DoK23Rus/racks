<?php

namespace App\Models\ValueObjects;

use App\Domain\Interfaces\SiteInterfaces\SiteEntity;

/**
 * Value object for site PATCHing (reverse DTO)
 */
class SiteAttributesValueObject
{
    /**
     * @var array<mixed>
     */
    private array $attributesForSite = [];

    /**
     * @var SiteEntity
     */
    private SiteEntity $site;

    /**
     * @param  SiteEntity  $site
     */
    public function __construct(SiteEntity $site)
    {
        $this->site = $site;
        $this->setName();
        $this->setUpdatedBy();
        $this->setDescription();
        $this->setDepartmentId();
    }

    /**
     * @return void
     */
    public function setName(): void
    {
        $name = $this->site->getName();
        if ($name) {
            $this->attributesForSite += ['name' => $name];
        }
    }

    /**
     * @return void
     */
    public function setUpdatedBy(): void
    {
        $updatedBy = $this->site->getUpdatedBy();
        if ($updatedBy) {
            $this->attributesForSite += ['updated_by' => $updatedBy];
        }
    }

    /**
     * @return void
     */
    public function setDescription(): void
    {
        $description = $this->site->getDescription();
        if ($description) {
            $this->attributesForSite += ['description' => $description];
        }
    }

    /**
     * @return void
     */
    public function setDepartmentId(): void
    {
        $departmentId = $this->site->getDepartmentId();
        if ($departmentId) {
            $this->attributesForSite += ['department_id' => $departmentId];
        }
    }

    /**
     * @return array<mixed> Get attributes array
     */
    public function toArray(): array
    {
        return $this->attributesForSite;
    }
}
