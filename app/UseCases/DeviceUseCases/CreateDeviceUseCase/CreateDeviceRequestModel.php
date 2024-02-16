<?php

namespace App\UseCases\DeviceUseCases\CreateDeviceUseCase;

use App\Models\User;

class CreateDeviceRequestModel
{
    /**
     * @param  array<mixed>  $attributes
     */
    public function __construct(
        private readonly array $attributes,
        private readonly User $user
    ) {
    }

    public function getUserName(): string
    {
        return $this->user['name'];
    }

    public function getRackId(): int
    {
        return $this->attributes['rack_id'];
    }

    public function getLocation(): bool
    {
        return $this->attributes['has_backside_location'];
    }

    /**
     * @return array<int>
     */
    public function getUnits(): array
    {
        return $this->attributes['units'];
    }

    public function getVendor(): ?string
    {
        return $this->attributes['vendor'] ?? null;
    }

    public function getModel(): ?string
    {
        return $this->attributes['model'] ?? null;
    }

    public function getType(): ?string
    {
        return $this->attributes['type'] ?? null;
    }

    public function getStatus(): ?string
    {
        return $this->attributes['status'] ?? null;
    }

    public function getHostname(): ?string
    {
        return $this->attributes['hostname'] ?? null;
    }

    public function getIp(): ?string
    {
        return $this->attributes['ip'] ?? null;
    }

    public function getStack(): ?int
    {
        return $this->attributes['stack'] ?? null;
    }

    public function getPortsAmount(): ?int
    {
        return $this->attributes['ports_amount'] ?? null;
    }

    public function getSoftwareVersion(): ?string
    {
        return $this->attributes['software_version'] ?? null;
    }

    public function getPowerType(): ?string
    {
        return $this->attributes['power_type'] ?? null;
    }

    public function getPowerW(): ?int
    {
        return $this->attributes['power_w'] ?? null;
    }

    public function getPowerV(): ?int
    {
        return $this->attributes['power_v'] ?? null;
    }

    public function getPowerACDC(): ?string
    {
        return $this->attributes['power_ac_dc'] ?? null;
    }

    public function getSerialNumber(): ?string
    {
        return $this->attributes['serial_number'] ?? null;
    }

    public function getDescription(): ?string
    {
        return $this->attributes['description'] ?? null;
    }

    public function getProject(): ?string
    {
        return $this->attributes['project'] ?? null;
    }

    public function getOwnership(): ?string
    {
        return $this->attributes['ownership'] ?? null;
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
}
