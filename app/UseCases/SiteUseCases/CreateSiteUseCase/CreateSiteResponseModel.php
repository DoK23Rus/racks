<?php

namespace App\UseCases\SiteUseCases\CreateSiteUseCase;

use App\Domain\Interfaces\SiteInterfaces\SiteEntity;

class CreateSiteResponseModel
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
