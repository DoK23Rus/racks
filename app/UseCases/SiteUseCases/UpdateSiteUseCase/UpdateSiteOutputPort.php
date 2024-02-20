<?php

namespace App\UseCases\SiteUseCases\UpdateSiteUseCase;

use App\Domain\Interfaces\ViewModel;

interface UpdateSiteOutputPort
{
    /**
     * @param  UpdateSiteResponseModel  $response
     * @return ViewModel
     */
    public function siteUpdated(UpdateSiteResponseModel $response): ViewModel;

    /**
     * @param  UpdateSiteResponseModel  $response
     * @return ViewModel
     */
    public function noSuchSite(UpdateSiteResponseModel $response): ViewModel;

    /**
     * @param  UpdateSiteResponseModel  $response
     * @return ViewModel
     */
    public function permissionException(UpdateSiteResponseModel $response): ViewModel;

    /**
     * @param  UpdateSiteResponseModel  $response
     * @param  \Throwable  $e
     * @return ViewModel
     */
    public function unableToUpdateSite(UpdateSiteResponseModel $response, \Throwable $e): ViewModel;
}
