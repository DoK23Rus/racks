<?php

namespace App\Domain\Interfaces\RackInterfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface RackRepository
{
    public function create(RackEntity $rack): RackEntity;

    public function getById(int $id): RackEntity|RackBusinessRules;

    public function lockById(int $id): void;

    public function updateBusyUnits(RackEntity $rack): int;

    public function delete(RackEntity $rack): int;

    public function update(RackEntity $rack): RackEntity;

    /**
     * @param  int  $roomId  Room ID
     * @return array<string> Rack names list for room
     */
    public function getNamesListByRoomId(int $roomId): array;

    public function lockTable(): void;

    /**
     * @return array{
     *     region_name: string,
     *     department_name: string,
     *     site_name: string,
     *     building_name: string,
     *     room_name: string,
     * } Rack location
     */
    public function getLocation(?string $id): array;

    /**
     * @return array{
     *     item_type: string,
     *     array<string>
     * } Rack vendors
     */
    public function getVendors(): array;

    /**
     * @return array{
     *     item_type: string,
     *     array<string>
     * } Rack models
     */
    public function getModels(): array;

    /**
     * @param  string|null  $perPage  Racks per page
     * @param  array<string>  $columns  Columns needed
     * @return LengthAwarePaginator Paginator
     */
    public function getAll(?string $perPage, array $columns): LengthAwarePaginator;
}
