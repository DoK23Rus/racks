<?php

namespace App\UseCases\SiteUseCases\UpdateSiteUseCase;

use App\Domain\Interfaces\SiteInterfaces\SiteEntity;

class UpdateSiteResponseModel
{
    public function __construct(
        private readonly SiteEntity $site
    ) {
    }

    public function getSite(): SiteEntity
    {
        return $this->site;
    }
}
