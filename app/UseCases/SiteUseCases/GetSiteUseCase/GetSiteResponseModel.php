<?php

namespace App\UseCases\SiteUseCases\GetSiteUseCase;

use App\Domain\Interfaces\SiteInterfaces\SiteEntity;

class GetSiteResponseModel
{
    public function __construct(
        private readonly ?SiteEntity $site,
    ) {
    }

    public function getSite(): ?SiteEntity
    {
        return $this->site;
    }
}
