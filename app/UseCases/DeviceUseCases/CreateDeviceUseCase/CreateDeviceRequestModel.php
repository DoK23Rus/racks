<?php

namespace App\UseCases\DeviceUseCases\CreateDeviceUseCase;

use App\Models\User;

class CreateDeviceRequestModel
{
    /**
     * @param  array<mixed>  $attributes
     * @param  User  $user
     */
    public function __construct(
        private readonly array $attributes,
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
    public function getRackId(): int
    {
        return $this->attributes['rack_id'];
    }

    /**
     * @return bool
     */
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
    public function getType(): ?string
    {
        return $this->attributes['type'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->attributes['status'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getHostname(): ?string
    {
        return $this->attributes['hostname'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getIp(): ?string
    {
        return $this->attributes['ip'] ?? null;
    }

    /**
     * @return int|null
     */
    public function getStack(): ?int
    {
        return $this->attributes['stack'] ?? null;
    }

    /**
     * @return int|null
     */
    public function getPortsAmount(): ?int
    {
        return $this->attributes['ports_amount'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getSoftwareVersion(): ?string
    {
        return $this->attributes['software_version'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getPowerType(): ?string
    {
        return $this->attributes['power_type'] ?? null;
    }

    /**
     * @return int|null
     */
    public function getPowerW(): ?int
    {
        return $this->attributes['power_w'] ?? null;
    }

    /**
     * @return int|null
     */
    public function getPowerV(): ?int
    {
        return $this->attributes['power_v'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getPowerACDC(): ?string
    {
        return $this->attributes['power_ac_dc'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getSerialNumber(): ?string
    {
        return $this->attributes['serial_number'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->attributes['description'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getProject(): ?string
    {
        return $this->attributes['project'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getOwnership(): ?string
    {
        return $this->attributes['ownership'] ?? null;
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
}
