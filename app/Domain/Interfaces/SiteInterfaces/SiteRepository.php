<?php

namespace App\Domain\Interfaces\SiteInterfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface SiteRepository
{
    public function getById(int $id): SiteEntity;

    public function create(SiteEntity $site): SiteEntity;

    public function update(SiteEntity $site): SiteEntity;

    public function delete(SiteEntity $site): int;

    public function getAll(?string $perPage): LengthAwarePaginator;
}
