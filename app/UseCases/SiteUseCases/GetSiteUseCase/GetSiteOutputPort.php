<?php

namespace App\UseCases\SiteUseCases\GetSiteUseCase;

use App\Domain\Interfaces\ViewModel;

interface GetSiteOutputPort
{
    /**
     * @param  GetSiteResponseModel  $response
     * @return ViewModel
     */
    public function retrieveSite(GetSiteResponseModel $response): ViewModel;

    /**
     * @param  GetSiteResponseModel  $response
     * @return ViewModel
     */
    public function noSuchSite(GetSiteResponseModel $response): ViewModel;
}
