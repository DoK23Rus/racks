<?php

namespace App\Repositories;

use App\Domain\Interfaces\UserInterfaces\UserEntity;
use App\Domain\Interfaces\UserInterfaces\UserRepository;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class UserDatabaseRepository implements UserRepository
{
    public function exists(UserEntity $user): bool
    {
        return User::where([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
        ])->exists();
    }

    public function create(UserEntity $user): UserEntity
    {
        return User::create([
            'name' => $user->getName(),
            'full_name' => $user->getFullName(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'department_id' => $user->getDepartmentId(),
        ]);
    }

    public function update(UserEntity $user): UserEntity
    {
        return tap(User::where('id', $user->getId())
            ->first())
            ->update([
                'name' => $user->getName(),
                'full_name' => $user->getFullName(),
                'email' => $user->getEmail(),
                'department_id' => $user->getDepartmentId(),
            ]);
    }

    public function getAll(?string $perPage): LengthAwarePaginator
    {
        return User::paginate($perPage);
    }

    public function getById(int $id): UserEntity
    {
        return User::where('id', $id)
            ->get()
            ->firstOrFail();
    }

    public function updatePassword(UserEntity $user): UserEntity
    {
        return tap(User::where('id', $user->getId())
            ->first())
            ->update([
                'password' => $user->getPassword(),
            ]);
    }

    public function delete(UserEntity $user): int
    {
        return User::where('id', $user->getId())
            ->first()
            ->delete();
    }
}
