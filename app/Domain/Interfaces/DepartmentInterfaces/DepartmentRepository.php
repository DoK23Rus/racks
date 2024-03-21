<?php

namespace App\Domain\Interfaces\DepartmentInterfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface DepartmentRepository
{
    /**
     * @param  int  $id
     * @return DepartmentEntity
     */
    public function getById(int $id): DepartmentEntity;

    /**
     * @param  DepartmentEntity  $department
     * @return bool
     */
    public function exists(DepartmentEntity $department): bool;

    /**
     * @param  DepartmentEntity  $department
     * @return DepartmentEntity
     */
    public function create(DepartmentEntity $department): DepartmentEntity;

    /**
     * @param  DepartmentEntity  $department
     * @return int
     */
    public function delete(DepartmentEntity $department): int;

    /**
     * @param  DepartmentEntity  $department
     * @return DepartmentEntity
     */
    public function update(DepartmentEntity $department): DepartmentEntity;

    /**
     * @param  string|null  $perPage
     * @return LengthAwarePaginator
     */
    public function getAll(?string $perPage): LengthAwarePaginator;
}
