<?php

namespace App\Domain\Interfaces\RegionInterfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface RegionRepository
{
    /**
     * @param  int  $id
     * @return RegionEntity
     */
    public function getById(int $id): RegionEntity;

    /**
     * @param  RegionEntity  $region
     * @return bool
     */
    public function exists(RegionEntity $region): bool;

    /**
     * @param  RegionEntity  $region
     * @return RegionEntity
     */
    public function create(RegionEntity $region): RegionEntity;

    /**
     * @param  RegionEntity  $region
     * @return int
     */
    public function delete(RegionEntity $region): int;

    /**
     * @param  RegionEntity  $region
     * @return RegionEntity
     */
    public function update(RegionEntity $region): RegionEntity;

    /**
     * @return array{
     *     id: int,
     *     region_name: string,
     *     children: array{
     *         id: int,
     *         department_name: string,
     *         children: array{
     *             id: int,
     *             site_name: string,
     *             children: array{
     *                 id: int,
     *                 building_name: string,
     *                 children: array{
     *                     id: int,
     *                     room_name: string,
     *                     children: array{
     *                         id: int,
     *                         rack_name: string,
     *                     }
     *                 }
     *             }
     *         }
     *     }
     * } Tree structure
     */
    public function getTreeView(): array;

    /**
     * @param  string|null  $perPage
     * @return LengthAwarePaginator
     */
    public function getAll(?string $perPage): LengthAwarePaginator;
}
