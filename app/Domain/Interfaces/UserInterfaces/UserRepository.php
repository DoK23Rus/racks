<?php

namespace App\Domain\Interfaces\UserInterfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepository
{
    /**
     * @param  UserEntity  $user
     * @return bool
     */
    public function exists(UserEntity $user): bool;

    /**
     * @param  UserEntity  $user
     * @return UserEntity
     */
    public function create(UserEntity $user): UserEntity;

    /**
     * @param  string|null  $perPage
     * @return LengthAwarePaginator
     */
    public function getAll(?string $perPage): LengthAwarePaginator;

    /**
     * @param  int  $id
     * @return UserEntity
     */
    public function getById(int $id): UserEntity;

    /**
     * @param  UserEntity  $user
     * @return UserEntity
     */
    public function updatePassword(UserEntity $user): UserEntity;

    /**
     * @param  UserEntity  $user
     * @return UserEntity
     */
    public function update(UserEntity $user): UserEntity;

    /**
     * @param  UserEntity  $user
     * @return int
     */
    public function delete(UserEntity $user): int;
}
