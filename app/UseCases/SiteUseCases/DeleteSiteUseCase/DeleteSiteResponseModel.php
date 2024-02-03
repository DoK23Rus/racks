<?php

namespace App\UseCases\SiteUseCases\DeleteSiteUseCase;

use App\Domain\Interfaces\SiteInterfaces\SiteEntity;

class DeleteSiteResponseModel
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
