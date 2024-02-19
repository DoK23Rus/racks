<?php

namespace App\Domain\Interfaces\BuildingInterfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface BuildingRepository
{
    /**
     * @param  int  $id
     * @return BuildingEntity
     */
    public function getById(int $id): BuildingEntity;

    /**
     * @param  int  $siteId
     * @return array<string> Building names list for site
     */
    public function getNamesListBySiteId(int $siteId): array;

    /**
     * @param  BuildingEntity  $building
     * @return BuildingEntity
     */
    public function create(BuildingEntity $building): BuildingEntity;

    /**
     * @param  BuildingEntity  $building
     * @return BuildingEntity
     */
    public function update(BuildingEntity $building): BuildingEntity;

    /**
     * @param  BuildingEntity  $building
     * @return int
     */
    public function delete(BuildingEntity $building): int;

    /**
     * @return void
     */
    public function lockTable(): void;

    /**
     * @param  string|null  $perPage
     * @return LengthAwarePaginator
     */
    public function getAll(?string $perPage): LengthAwarePaginator;
}
