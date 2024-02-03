<?php

namespace App\UseCases\SiteUseCases\DeleteSiteUseCase;

use App\Domain\Interfaces\ViewModel;

interface DeleteSiteOutputPort
{
    public function siteDeleted(DeleteSiteResponseModel $response): ViewModel;

    public function noSuchSite(DeleteSiteResponseModel $response): ViewModel;

    public function permissionException(DeleteSiteResponseModel $response): ViewModel;

    public function unableToDeleteSite(DeleteSiteResponseModel $response, \Throwable $e): ViewModel;
}
