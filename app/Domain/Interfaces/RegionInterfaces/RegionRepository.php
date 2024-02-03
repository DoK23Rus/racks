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

    public function getTreeView(): array;

    public function getAll(?string $perPage): LengthAwarePaginator;
}
