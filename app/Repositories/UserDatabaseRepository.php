<?php

namespace App\Repositories;

use App\Domain\Interfaces\UserInterfaces\UserEntity;
use App\Domain\Interfaces\UserInterfaces\UserRepository;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class UserDatabaseRepository implements UserRepository
{
    /**
     * @param  UserEntity  $user
     * @return bool
     */
    public function exists(UserEntity $user): bool
    {
        return User::where([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
        ])->exists();
    }

    /**
     * @param  UserEntity  $user
     * @return UserEntity
     */
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

    /**
     * @param  UserEntity  $user
     * @return UserEntity
     */
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

    /**
     * @param  string|null  $perPage
     * @return LengthAwarePaginator
     */
    public function getAll(?string $perPage): LengthAwarePaginator
    {
        return User::paginate($perPage);
    }

    /**
     * @param  int  $id
     * @return UserEntity
     */
    public function getById(int $id): UserEntity
    {
        return User::where('id', $id)
            ->get()
            ->firstOrFail();
    }

    /**
     * @param  UserEntity  $user
     * @return UserEntity
     */
    public function updatePassword(UserEntity $user): UserEntity
    {
        return tap(User::where('id', $user->getId())
            ->first())
            ->update([
                'password' => $user->getPassword(),
            ]);
    }

    /**
     * @param  UserEntity  $user
     * @return int
     */
    public function delete(UserEntity $user): int
    {
        return User::where('id', $user->getId())
            ->first()
            ->delete();
    }
}
