<?php

namespace App\Domain\Interfaces\UserInterfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepository
{
    public function exists(UserEntity $user): bool;

    public function create(UserEntity $user): UserEntity;

    public function getAll(?string $perPage): LengthAwarePaginator;

    public function getById(int $id): UserEntity;

    public function updatePassword(UserEntity $user): UserEntity;

    public function update(UserEntity $user): UserEntity;

    public function delete(UserEntity $user): int;
}
