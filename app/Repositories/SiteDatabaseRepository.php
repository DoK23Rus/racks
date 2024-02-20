<?php

namespace App\Repositories;

use App\Domain\Interfaces\SiteInterfaces\SiteEntity;
use App\Domain\Interfaces\SiteInterfaces\SiteRepository;
use App\Models\Site;
use Illuminate\Pagination\LengthAwarePaginator;

class SiteDatabaseRepository implements SiteRepository
{
    /**
     * @param  int  $id
     * @return SiteEntity
     */
    public function getById(int $id): SiteEntity
    {
        return Site::where('id', $id)
            ->get()
            ->firstOrFail();
    }

    /**
     * @param  SiteEntity  $site
     * @return SiteEntity
     */
    public function create(SiteEntity $site): SiteEntity
    {
        return Site::create([
            'name' => $site->getName(),
            'department_id' => $site->getDepartmentId(),
            'updated_by' => $site->getUpdatedBy(),
        ]);
    }

    /**
     * @param  SiteEntity  $site
     * @return SiteEntity
     */
    public function update(SiteEntity $site): SiteEntity
    {
        return tap(Site::where('id', $site->getId())
            ->first())
            ->update([
                'name' => $site->getName(),
            ]);
    }

    /**
     * @param  SiteEntity  $site
     * @return int
     */
    public function delete(SiteEntity $site): int
    {
        return Site::where('id', $site->getId())
            ->first()
            ->delete();
    }

    /**
     * @param  string|null  $perPage
     * @return LengthAwarePaginator
     */
    public function getAll(?string $perPage): LengthAwarePaginator
    {
        return Site::paginate($perPage);
    }
}
