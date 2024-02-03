<?php

namespace App\UseCases\SiteUseCases\UpdateSiteUseCase;

use App\Domain\Interfaces\ViewModel;

interface UpdateSiteOutputPort
{
    public function siteUpdated(UpdateSiteResponseModel $response): ViewModel;

    public function noSuchSite(UpdateSiteResponseModel $response): ViewModel;

    public function permissionException(UpdateSiteResponseModel $response): ViewModel;

    public function unableToUpdateSite(UpdateSiteResponseModel $response, \Throwable $e): ViewModel;
}
