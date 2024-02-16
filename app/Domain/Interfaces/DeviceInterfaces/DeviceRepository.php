<?php

namespace App\Domain\Interfaces\DeviceInterfaces;

interface DeviceRepository
{
    public function create(DeviceEntity $device): DeviceEntity;

    public function getById(int $id): DeviceEntity;

    /**
     * @param  string|null  $rackId  Rack ID
     * @return array{string: string|int|bool} Rack model to array
     */
    public function getByRackId(?string $rackId): array;

    public function delete(DeviceEntity $device): int;

    public function update(DeviceEntity $device): DeviceEntity;

    public function updateUnits(DeviceEntity $device): int;

    /**
     * @param  string|null  $id  Rack ID
     * @return array<array{
     *     region_name: string,
     *     department_name: string,
     *     site_name: string,
     *     building_name: string,
     *     room_name: string,
     *     rack_name: string
     * }> Device location array
     */
    public function getLocation(?string $id): array;

    /**
     * @return array{
     *     item_type: string,
     *     array<string>
     * } Device vendors
     */
    public function getVendors(): array;

    /**
     * @return array{
     *     item_type: string,
     *     array<string>
     * } Device models
     */
    public function getModels(): array;
}
