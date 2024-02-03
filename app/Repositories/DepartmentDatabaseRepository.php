<?php

namespace App\Repositories;

use App\Domain\Interfaces\DepartmentInterfaces\DepartmentEntity;
use App\Domain\Interfaces\DepartmentInterfaces\DepartmentRepository;
use App\Models\Department;
use Illuminate\Pagination\LengthAwarePaginator;

class DepartmentDatabaseRepository implements DepartmentRepository
{
    public function getById(int $id): DepartmentEntity
    {
        return Department::where('id', $id)
            ->get()
            ->firstOrFail();
    }

    public function exists(DepartmentEntity $department): bool
    {
        return Department::where([
            'name' => $department->getName(),
            'region_id' => $department->getRegionId(),
        ])->exists();
    }

    public function create(DepartmentEntity $department): DepartmentEntity
    {
        return Department::create([
            'name' => $department->getName(),
            'region_id' => $department->getRegionId(),
        ]);
    }

    public function delete(DepartmentEntity $department): int
    {
        return Department::where('id', $department->getId())
            ->first()
            ->delete();
    }

    public function update(DepartmentEntity $department): DepartmentEntity
    {
        return tap(Department::where('id', $department->getId())
            ->first())
            ->update([
                'name' => $department->getName(),
            ]);
    }

    public function getAll(?string $perPage): LengthAwarePaginator
    {
        return Department::paginate($perPage);
    }
}
