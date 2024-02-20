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
        return Building::create([
            'name' => $building->getName(),
            'site_id' => $building->getSiteId(),
            'department_id' => $building->getDepartmentId(),
            'updated_by' => $building->getUpdatedBy(),
        ]);
    }

    /**
     * @param  BuildingEntity  $building
     * @return BuildingEntity
     */
    public function update(BuildingEntity $building): BuildingEntity
    {
        return tap(Building::where('id', $building->getId())
            ->first())
            ->update([
                'name' => $building->getName(),
            ]);
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
