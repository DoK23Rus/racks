<?php

namespace App\Domain\Interfaces\SiteInterfaces;

use App\UseCases\SiteUseCases\CreateSiteUseCase\CreateSiteRequestModel;
use App\UseCases\SiteUseCases\UpdateSiteUseCase\UpdateSiteRequestModel;

interface SiteFactory
{
    /**
     * @param  CreateSiteRequestModel  $request
     * @return SiteEntity
     */
    public function makeFromCreateRequest(CreateSiteRequestModel $request): SiteEntity;

    /**
     * @param  UpdateSiteRequestModel  $request
     * @return SiteEntity
     */
    public function makeFromPatchRequest(UpdateSiteRequestModel $request): SiteEntity;
}
