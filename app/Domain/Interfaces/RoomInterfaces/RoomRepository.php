<?php

namespace App\Domain\Interfaces\RoomInterfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface RoomRepository
{
    /**
     * @param  int  $id
     * @return RoomEntity
     */
    public function getById(int $id): RoomEntity;

    /**
     * @param  int  $buildingId
     * @return array<string>
     */
    public function getNamesListByBuildingId(int $buildingId): array;

    /**
     * @param  RoomEntity  $room
     * @return RoomEntity
     */
    public function create(RoomEntity $room): RoomEntity;

    /**
     * @param  RoomEntity  $room
     * @return RoomEntity
     */
    public function update(RoomEntity $room): RoomEntity;

    /**
     * @param  RoomEntity  $room
     * @return int
     */
    public function delete(RoomEntity $room): int;

    /**
     * @return void
     */
    public function lockTable(): void;

    /**
     * @param  string|null  $perPage
     * @return LengthAwarePaginator
     */
    public function getAll(?string $perPage): LengthAwarePaginator;

    /**
     * @param  string|null  $id
     * @return array<array{
     *      region_name: string,
     *      department_name: string,
     *      site_name: string,
     *      building_name: string
     * }>
     */
    public function getLocation(?string $id): array;
}
