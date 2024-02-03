<?php

namespace App\Domain\Interfaces\RackInterfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface RackRepository
{
    public function create(RackEntity $rack): RackEntity;

    public function getById(int $id): RackEntity|RackBusinessRules;

    public function lockById(int $id): void;

    public function updateBusyUnits(RackEntity $rack): int;

    public function delete(RackEntity $rack): int;

    public function update(RackEntity $rack): RackEntity;

    public function getNamesListByRoomId(int $roomId): array;

    public function lockTable(): void;

    public function getLocation(?string $id): array;

    public function getVendors(): array;

    public function getModels(): array;

    public function getAll(?string $perPage, array $columns): LengthAwarePaginator;
}
