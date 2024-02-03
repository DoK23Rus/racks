<?php

namespace App\Repositories;

use App\Domain\Interfaces\RackInterfaces\RackBusinessRules;
use App\Domain\Interfaces\RackInterfaces\RackEntity;
use App\Domain\Interfaces\RackInterfaces\RackRepository;
use App\Models\Rack;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class RackDatabaseRepository implements RackRepository
{
    public function getById(int $id): RackEntity|RackBusinessRules
    {
        return Rack::where('id', $id)
            ->get()
            ->firstOrFail();
    }

    public function create(RackEntity $rack): RackEntity
    {
        return Rack::create($rack->getAttributeSet()->getArray());
    }

    public function updateBusyUnits(RackEntity $rack): int
    {
        return Rack::where('id', $rack->getId())
            ->first()
            ->update([
                'busy_units' => $rack->getBusyUnits()->getBusyUnits(),
            ]);
    }

    public function lockById(int $id): void
    {
        DB::table('racks')
            ->where('id', $id)
            ->sharedLock();
    }

    public function delete(RackEntity $rack): int
    {
        return Rack::where('id', $rack->getId())
            ->first()
            ->delete();
    }

    public function update(RackEntity $rack): RackEntity
    {

        return tap(Rack::where('id', $rack->getId())
            ->first())
            ->update(
                $rack->getAttributeSet()->getArray()
            );
    }

    public function getNamesListByRoomId(int $roomId): array
    {
        return Rack::where('room_id', $roomId)
            ->pluck('name')
            ->toArray();
    }

    public function lockTable(): void
    {
        DB::table('rack')
            ->sharedLock();
    }

    public function getLocation(?string $id): array
    {
        return DB::table('racks')
            ->where('racks.id', $id)
            ->select(
                'regions.name as region_name',
                'departments.name as department_name',
                'sites.name as site_name',
                'buildings.name as building_name',
                'rooms.name as room_name',
            )
            ->join('rooms', 'racks.room_id', '=', 'rooms.id')
            ->join('buildings', 'rooms.building_id', '=', 'buildings.id')
            ->join('sites', 'buildings.site_id', '=', 'sites.id')
            ->join('departments', 'sites.department_id', '=', 'departments.id')
            ->join('regions', 'departments.region_id', '=', 'regions.id')
            ->get()
            ->toArray();
    }

    public function getVendors(): array
    {
        return DB::table('racks')
            ->select('vendor')
            ->distinct()
            ->pluck('vendor')
            ->toArray();
    }

    public function getModels(): array
    {
        return DB::table('racks')
            ->select('model')
            ->distinct()
            ->pluck('model')
            ->toArray();
    }

    public function getAll(?string $perPage, array $columns): LengthAwarePaginator
    {
        return Rack::paginate($perPage, $columns);
    }
}
