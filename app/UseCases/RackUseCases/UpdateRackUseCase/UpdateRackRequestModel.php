<?php

namespace App\UseCases\RackUseCases\UpdateRackUseCase;

use App\Models\User;

class UpdateRackRequestModel
{
    /**
     * @param  array<mixed>  $attributes
     * @param  int  $id
     * @param  User  $user
     */
    public function __construct(
        private readonly array $attributes,
        private readonly int $id,
        private readonly User $user
    ) {
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->user['name'];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->attributes['name'] ?? null;
    }

    /**
     * @return int|null
     */
    public function getAmount(): ?int
    {
        return $this->attributes['amount'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getVendor(): ?string
    {
        return $this->attributes['vendor'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getModel(): ?string
    {
        return $this->attributes['model'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->attributes['description'] ?? null;
    }

    /**
     * @return bool|null
     */
    public function getHasNumberingFromTopToBottom(): ?bool
    {
        return $this->attributes['has_numbering_from_top_to_bottom'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getResponsible(): ?string
    {
        return $this->attributes['responsible'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getFinanciallyResponsiblePerson(): ?string
    {
        return $this->attributes['financially_responsible_person'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getInventoryNumber(): ?string
    {
        return $this->attributes['inventory_number'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getFixedAsset(): ?string
    {
        return $this->attributes['fixed_asset'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getLinkToDocs(): ?string
    {
        return $this->attributes['link_to_docs'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getRow(): ?string
    {
        return $this->attributes['row'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getPlace(): ?string
    {
        return $this->attributes['place'] ?? null;
    }

    /**
     * @return int|null
     */
    public function getHeight(): ?int
    {
        return $this->attributes['height'] ?? null;
    }

    /**
     * @return int|null
     */
    public function getWidth(): ?int
    {
        return $this->attributes['width'] ?? null;
    }

    /**
     * @return int|null
     */
    public function getDepth(): ?int
    {
        return $this->attributes['depth'] ?? null;
    }

    /**
     * @return int|null
     */
    public function getUnitWidth(): ?int
    {
        return $this->attributes['unit_width'] ?? null;
    }

    /**
     * @return int|null
     */
    public function getUnitDepth(): ?int
    {
        return $this->attributes['unit_depth'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->attributes['type'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getFrame(): ?string
    {
        return $this->attributes['frame'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getPlaceType(): ?string
    {
        return $this->attributes['place_type'] ?? null;
    }

    /**
     * @return int|null
     */
    public function getMaxLoad(): ?int
    {
        return $this->attributes['max_load'] ?? null;
    }

    /**
     * @return int|null
     */
    public function getPowerSockets(): ?int
    {
        return $this->attributes['power_sockets'] ?? null;
    }

    /**
     * @return int|null
     */
    public function getPowerSocketsUps(): ?int
    {
        return $this->attributes['power_sockets_ups'] ?? null;
    }

    /**
     * @return bool|null
     */
    public function getHasExternalUps(): ?bool
    {
        return $this->attributes['has_external_ups'] ?? null;
    }

    /**
     * @return bool|null
     */
    public function getHasCooler(): ?bool
    {
        return $this->attributes['has_cooler'] ?? null;
    }

    /**
     * Cannot be updated
     *
     * @return int|null
     */
    public function getRoomId(): ?int
    {
        return null;
    }

    /**
     * Cannot be updated
     *
     * @return int|null
     */
    public function getDepartmentId(): ?int
    {
        return null;
    }
}
