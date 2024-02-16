<?php

namespace App\Domain\Interfaces\RegionInterfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface RegionRepository
{
    public function getById(int $id): RegionEntity;

    public function exists(RegionEntity $region): bool;

    public function create(RegionEntity $region): RegionEntity;

    public function delete(RegionEntity $region): int;

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

    public function getAll(?string $perPage): LengthAwarePaginator;
}
