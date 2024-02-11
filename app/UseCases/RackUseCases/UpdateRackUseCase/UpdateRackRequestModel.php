<?php

namespace App\UseCases\RackUseCases\UpdateRackUseCase;

use App\Models\User;

class UpdateRackRequestModel
{
    /**
     * @param  array<mixed>  $attributes
     */
    public function __construct(
        private readonly array $attributes,
        private readonly int $id,
        private readonly User $user
    ) {
    }

    public function getUserName(): string
    {
        return $this->user['name'];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->attributes['name'] ?? null;
    }

    public function getAmount(): ?int
    {
        return $this->attributes['amount'] ?? null;
    }

    public function getVendor(): ?string
    {
        return $this->attributes['vendor'] ?? null;
    }

    public function getModel(): ?string
    {
        return $this->attributes['model'] ?? null;
    }

    public function getDescription(): ?string
    {
        return $this->attributes['description'] ?? null;
    }

    public function getHasNumberingFromTopToBottom(): ?bool
    {
        return $this->attributes['has_numbering_from_top_to_bottom'] ?? null;
    }

    public function getResponsible(): ?string
    {
        return $this->attributes['responsible'] ?? null;
    }

    public function getFinanciallyResponsiblePerson(): ?string
    {
        return $this->attributes['financially_responsible_person'] ?? null;
    }

    public function getInventoryNumber(): ?string
    {
        return $this->attributes['inventory_number'] ?? null;
    }

    public function getFixedAsset(): ?string
    {
        return $this->attributes['fixed_asset'] ?? null;
    }

    public function getLinkToDocs(): ?string
    {
        return $this->attributes['link_to_docs'] ?? null;
    }

    public function getRow(): ?string
    {
        return $this->attributes['row'] ?? null;
    }

    public function getPlace(): ?string
    {
        return $this->attributes['place'] ?? null;
    }

    public function getHeight(): ?int
    {
        return $this->attributes['height'] ?? null;
    }

    public function getWidth(): ?int
    {
        return $this->attributes['width'] ?? null;
    }

    public function getDepth(): ?int
    {
        return $this->attributes['depth'] ?? null;
    }

    public function getUnitWidth(): ?int
    {
        return $this->attributes['unit_width'] ?? null;
    }

    public function getUnitDepth(): ?int
    {
        return $this->attributes['unit_depth'] ?? null;
    }

    public function getType(): ?string
    {
        return $this->attributes['type'] ?? null;
    }

    public function getFrame(): ?string
    {
        return $this->attributes['frame'] ?? null;
    }

    public function getPlaceType(): ?string
    {
        return $this->attributes['place_type'] ?? null;
    }

    public function getMaxLoad(): ?int
    {
        return $this->attributes['max_load'] ?? null;
    }

    public function getPowerSockets(): ?int
    {
        return $this->attributes['power_sockets'] ?? null;
    }

    public function getPowerSocketsUps(): ?int
    {
        return $this->attributes['power_sockets_ups'] ?? null;
    }

    public function getHasExternalUps(): ?bool
    {
        return $this->attributes['has_external_ups'] ?? null;
    }

    public function getHasCooler(): ?bool
    {
        return $this->attributes['has_cooler'] ?? null;
    }

    public function getRoomId(): ?int
    {
        return null;
    }

    public function getDepartmentId(): ?int
    {
        return null;
    }
}
