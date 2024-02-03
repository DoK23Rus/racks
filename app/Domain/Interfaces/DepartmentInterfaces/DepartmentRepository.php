<?php

namespace App\Domain\Interfaces\DepartmentInterfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface DepartmentRepository
{
    public function getById(int $id): DepartmentEntity;

    public function exists(DepartmentEntity $department): bool;

    public function create(DepartmentEntity $department): DepartmentEntity;

    public function delete(DepartmentEntity $department): int;

    public function update(DepartmentEntity $department): DepartmentEntity;

    public function getAll(?string $perPage): LengthAwarePaginator;
}
