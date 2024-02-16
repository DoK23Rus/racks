<?php

namespace App\Domain\Interfaces\RoomInterfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface RoomRepository
{
    public function getById(int $id): RoomEntity;

    /**
     * @param  int  $buildingId  Building ID
     * @return array<string> Room names list for building
     */
    public function getNamesListByBuildingId(int $buildingId): array;

    public function create(RoomEntity $room): RoomEntity;

    public function update(RoomEntity $room): RoomEntity;

    public function delete(RoomEntity $room): int;

    public function lockTable(): void;

    public function getAll(?string $perPage): LengthAwarePaginator;
}
