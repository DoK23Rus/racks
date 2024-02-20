<?php

namespace App\UseCases\SiteUseCases\DeleteSiteUseCase;

use App\Domain\Interfaces\SiteInterfaces\SiteEntity;

class DeleteSiteResponseModel
{
    /**
     * @param  SiteEntity|null  $site  Null for no such site response
     */
    public function __construct(
        private readonly ?SiteEntity $site
    ) {
    }

    /**
     * @return SiteEntity|null
     */
    public function getSite(): ?SiteEntity
    {
        return $this->site;
    }
}
