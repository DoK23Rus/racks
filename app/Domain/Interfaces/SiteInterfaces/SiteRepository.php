<?php

namespace App\Domain\Interfaces\SiteInterfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface SiteRepository
{
    /**
     * @param  int  $id
     * @return SiteEntity
     */
    public function getById(int $id): SiteEntity;

    /**
     * @param  SiteEntity  $site
     * @return SiteEntity
     */
    public function create(SiteEntity $site): SiteEntity;

    /**
     * @param  SiteEntity  $site
     * @return SiteEntity
     */
    public function update(SiteEntity $site): SiteEntity;

    /**
     * @param  SiteEntity  $site
     * @return int
     */
    public function delete(SiteEntity $site): int;

    /**
     * @param  string|null  $id
     * @return array<array{
     *     region_name: string,
     *     department_name: string
     * }>
     */
    public function getLocation(?string $id): array;

    /**
     * @param  string|null  $perPage
     * @return LengthAwarePaginator
     */
    public function getAll(?string $perPage): LengthAwarePaginator;
}
