<?php

namespace App\Domain\Interfaces\RackInterfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface RackRepository
{
    /**
     * @param  RackEntity  $rack
     * @return RackEntity
     */
    public function create(RackEntity $rack): RackEntity;

    /**
     * @param  int  $id
     * @return RackEntity|RackBusinessRules
     */
    public function getById(int $id): RackEntity|RackBusinessRules;

    /**
     * @param  int  $id
     * @return void
     */
    public function lockById(int $id): void;

    /**
     * @param  RackEntity  $rack
     * @return int
     */
    public function updateBusyUnits(RackEntity $rack): int;

    /**
     * @param  RackEntity  $rack
     * @return int
     */
    public function delete(RackEntity $rack): int;

    /**
     * @param  RackEntity  $rack
     * @return RackEntity
     */
    public function update(RackEntity $rack): RackEntity;

    /**
     * @param  int  $roomId  Room ID
     * @return array<string> Rack names list for room
     */
    public function getNamesListByRoomId(int $roomId): array;

    /**
     * @return void
     */
    public function lockTable(): void;

    /**
     * Rack location
     * Region>Department>Site>Building>Room
     *
     * @return array<array{
     *     region_name: string,
     *     department_name: string,
     *     site_name: string,
     *     building_name: string,
     *     room_name: string,
     * }> Rack location
     */
    public function getLocation(?string $id): array;

    /**
     * All rack vendors
     *
     * @return array{
     *     item_type: string,
     *     array<string>
     * } Rack vendors
     */
    public function getVendors(): array;

    /**
     * All rack models
     *
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
