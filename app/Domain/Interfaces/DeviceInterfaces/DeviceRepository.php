<?php

namespace App\Domain\Interfaces\DeviceInterfaces;

interface DeviceRepository
{
    public function create(DeviceEntity $device): DeviceEntity;

    public function getById(int $id): DeviceEntity;

    public function getByRackId(?string $rackId): array;

    public function delete(DeviceEntity $device): int;

    public function update(DeviceEntity $device): DeviceEntity;

    public function updateUnits(DeviceEntity $device): int;

    public function getLocation(?string $id): array;

    public function getVendors(): array;

    public function getModels(): array;
}
