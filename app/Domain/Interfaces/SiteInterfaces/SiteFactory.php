<?php

namespace App\Domain\Interfaces\SiteInterfaces;

use App\UseCases\SiteUseCases\CreateSiteUseCase\CreateSiteRequestModel;
use App\UseCases\SiteUseCases\UpdateSiteUseCase\UpdateSiteRequestModel;

interface SiteFactory
{
    public function makeFromId(int $id): SiteEntity;

    public function makeFromCreateRequest(CreateSiteRequestModel $request): SiteEntity;

    public function makeFromPutRequest(UpdateSiteRequestModel $request): SiteEntity;
}
