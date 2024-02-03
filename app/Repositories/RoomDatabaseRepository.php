<?php

namespace App\Repositories;

use App\Domain\Interfaces\RoomInterfaces\RoomEntity;
use App\Domain\Interfaces\RoomInterfaces\RoomRepository;
use App\Models\Room;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class RoomDatabaseRepository implements RoomRepository
{
    public function getById(int $id): RoomEntity
    {
        return Room::where('id', $id)
            ->get()
            ->firstOrFail();
    }

    public function getNamesListByBuildingId(int $buildingId): array
    {
        return Room::where('building_id', $buildingId)
            ->pluck('name')
            ->toArray();
    }

    public function create(RoomEntity $room): RoomEntity
    {
        return Room::create([
            'name' => $room->getName(),
            'building_id' => $room->getBuildingId(),
            'department_id' => $room->getDepartmentId(),
            'updated_by' => $room->getUpdatedBy(),
        ]);
    }

    public function update(RoomEntity $room): RoomEntity
    {
        return tap(Room::where('id', $room->getId())
            ->first())
            ->update([
                'name' => $room->getName(),
            ]);
    }

    public function delete(RoomEntity $room): int
    {
        return Room::where('id', $room->getId())
            ->first()
            ->delete();
    }

    public function lockTable(): void
    {
        DB::table('room')
            ->sharedLock();
    }

    public function getAll(?string $perPage): LengthAwarePaginator
    {
        return Room::paginate($perPage);
    }
}
