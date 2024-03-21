<?php

namespace App\Repositories;

use App\Domain\Interfaces\BuildingInterfaces\BuildingEntity;
use App\Domain\Interfaces\BuildingInterfaces\BuildingRepository;
use App\Models\Building;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class BuildingDatabaseRepository implements BuildingRepository
{
    /**
     * @param  int  $id
     * @return BuildingEntity
     */
    public function getById(int $id): BuildingEntity
    {
        return Building::where('id', $id)
            ->get()
            ->firstOrFail();
    }

    /**
     * @return array<string> $items
     */
    public function getNamesListBySiteId(int $siteId): array
    {
        return Building::where('site_id', $siteId)
            ->pluck('name')
            ->toArray();
    }

    /**
     * @param  BuildingEntity  $building
     * @return BuildingEntity
     */
    public function create(BuildingEntity $building): BuildingEntity
    {
        return Building::create($building->getAttributeSet()->toArray());
    }

    /**
     * @param  BuildingEntity  $building
     * @return BuildingEntity
     */
    public function update(BuildingEntity $building): BuildingEntity
    {
        return tap(Building::where('id', $building->getId())
            ->first())
            ->update(
                $building->getAttributeSet()->toArray()
            );
    }

    /**
     * @param  BuildingEntity  $building
     * @return int
     */
    public function delete(BuildingEntity $building): int
    {
        return Building::where('id', $building->getId())
            ->first()
            ->delete();
    }

    /**
     * @param  string|null  $id
     * @return array<array{
     *     region_name: string,
     *     department_name: string,
     *     site_name: string
     * }>
     */
    public function getLocation(?string $id): array
    {
        return DB::table('buildings')
            ->where('buildings.id', $id)
            ->select(
                'regions.name as region_name',
                'departments.name as department_name',
                'sites.name as site_name',
            )
            ->join('sites', 'buildings.site_id', '=', 'sites.id')
            ->join('departments', 'sites.department_id', '=', 'departments.id')
            ->join('regions', 'departments.region_id', '=', 'regions.id')
            ->get()
            ->toArray();
    }

    /**
     * @return void
     */
    public function lockTable(): void
    {
        DB::table('building')
            ->sharedLock();
    }

    /**
     * @param  string|null  $perPage
     * @return LengthAwarePaginator
     */
    public function getAll(?string $perPage): LengthAwarePaginator
    {
        return Building::paginate($perPage);
    }
}
