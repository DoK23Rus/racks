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
    /**
     * @param  int  $id
     * @return RackEntity|RackBusinessRules
     */
    public function getById(int $id): RackEntity|RackBusinessRules
    {
        return Rack::where('id', $id)
            ->get()
            ->firstOrFail();
    }

    /**
     * @param  RackEntity  $rack
     * @return RackEntity
     */
    public function create(RackEntity $rack): RackEntity
    {
        return Rack::create($rack->getAttributeSet()->toArray());
    }

    /**
     * @param  RackEntity  $rack
     * @return int
     */
    public function updateBusyUnits(RackEntity $rack): int
    {
        return Rack::where('id', $rack->getId())
            ->first()
            ->update([
                'busy_units' => $rack->getBusyUnits()->toArray(),
            ]);
    }

    /**
     * @param  int  $id
     * @return void
     */
    public function lockById(int $id): void
    {
        DB::table('racks')
            ->where('id', $id)
            ->sharedLock();
    }

    /**
     * @param  RackEntity  $rack
     * @return int
     */
    public function delete(RackEntity $rack): int
    {
        return Rack::where('id', $rack->getId())
            ->first()
            ->delete();
    }

    /**
     * @param  RackEntity  $rack
     * @return RackEntity
     */
    public function update(RackEntity $rack): RackEntity
    {

        return tap(Rack::where('id', $rack->getId())
            ->first())
            ->update(
                $rack->getAttributeSet()->toArray()
            );
    }

    /**
     * @param  int  $roomId
     * @return array<string>
     */
    public function getNamesListByRoomId(int $roomId): array
    {
        return Rack::where('room_id', $roomId)
            ->pluck('name')
            ->toArray();
    }

    /**
     * @return void
     */
    public function lockTable(): void
    {
        DB::table('rack')
            ->sharedLock();
    }

    /**
     * @param  string|null  $id
     * @return array<mixed>
     */
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

    /**
     * @return array<string>
     */
    public function getVendors(): array
    {
        return DB::table('racks')
            ->select('vendor')
            ->distinct()
            ->pluck('vendor')
            ->toArray();
    }

    /**
     * @return array<string>
     */
    public function getModels(): array
    {
        return DB::table('racks')
            ->select('model')
            ->distinct()
            ->pluck('model')
            ->toArray();
    }

    /**
     * @param  string|null  $perPage
     * @param  array<string>  $columns
     * @return LengthAwarePaginator
     */
    public function getAll(?string $perPage, array $columns): LengthAwarePaginator
    {
        return Rack::paginate($perPage, $columns);
    }
}
