<?php

namespace App\UseCases\SiteUseCases\CreateSiteUseCase;

use App\Domain\Interfaces\ViewModel;

interface CreateSiteOutputPort
{
    /**
     * @param  CreateSiteResponseModel  $response
     * @return ViewModel
     */
    public function siteCreated(CreateSiteResponseModel $response): ViewModel;

    /**
     * @param  CreateSiteResponseModel  $response
     * @param  \Throwable  $e
     * @return ViewModel
     */
    public function unableToCreateSite(CreateSiteResponseModel $response, \Throwable $e): ViewModel;

    /**
     * @param  CreateSiteResponseModel  $response
     * @return ViewModel
     */
    public function noSuchDepartment(CreateSiteResponseModel $response): ViewModel;

    /**
     * @param  CreateSiteResponseModel  $response
     * @return ViewModel
     */
    public function permissionException(CreateSiteResponseModel $response): ViewModel;
}
