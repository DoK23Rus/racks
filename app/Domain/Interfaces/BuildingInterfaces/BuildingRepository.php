<?php

namespace App\Domain\Interfaces\BuildingInterfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface BuildingRepository
{
    public function getById(int $id): BuildingEntity;

    public function getNamesListBySiteId(int $siteId): array;

    public function create(BuildingEntity $building): BuildingEntity;

    public function update(BuildingEntity $building): BuildingEntity;

    public function delete(BuildingEntity $building): int;

    public function lockTable(): void;

    public function getAll(?string $perPage): LengthAwarePaginator;
}
