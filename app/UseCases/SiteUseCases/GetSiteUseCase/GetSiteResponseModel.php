<?php

namespace App\UseCases\SiteUseCases\GetSiteUseCase;

use App\Domain\Interfaces\SiteInterfaces\SiteEntity;
use Illuminate\Http\Response;

class GetSiteResponseModel extends Response
{
    public function __construct(
        private readonly SiteEntity $site,
    ) {
    }

    public function getSite(): SiteEntity
    {
        return $this->site;
    }
}
