<?php

namespace App\UseCases\SiteUseCases\GetSiteUseCase;

use App\Domain\Interfaces\ViewModel;

interface GetSiteOutputPort
{
    public function retrieveSite(GetSiteResponseModel $response): ViewModel;

    public function noSuchSite(GetSiteResponseModel $response): ViewModel;
}
