<?php

namespace App\UseCases\SiteUseCases\UpdateSiteUseCase;

use App\Domain\Interfaces\SiteInterfaces\SiteEntity;

class UpdateSiteResponseModel
{
    /**
     * @param  SiteEntity  $site
     */
    public function __construct(
        private readonly SiteEntity $site
    ) {
    }

    /**
     * @return SiteEntity
     */
    public function getSite(): SiteEntity
    {
        return $this->site;
    }
}
