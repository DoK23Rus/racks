<?php

namespace App\UseCases\SiteUseCases\CreateSiteUseCase;

use App\Domain\Interfaces\ViewModel;

interface CreateSiteOutputPort
{
    public function siteCreated(CreateSiteResponseModel $response): ViewModel;

    public function unableToCreateSite(CreateSiteResponseModel $response, \Throwable $e): ViewModel;

    public function noSuchDepartment(CreateSiteResponseModel $response): ViewModel;

    public function permissionException(CreateSiteResponseModel $response): ViewModel;
}
