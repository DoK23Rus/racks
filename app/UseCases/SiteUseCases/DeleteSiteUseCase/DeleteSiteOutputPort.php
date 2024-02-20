<?php

namespace App\UseCases\SiteUseCases\DeleteSiteUseCase;

use App\Domain\Interfaces\ViewModel;

interface DeleteSiteOutputPort
{
    /**
     * @param  DeleteSiteResponseModel  $response
     * @return ViewModel
     */
    public function siteDeleted(DeleteSiteResponseModel $response): ViewModel;

    /**
     * @param  DeleteSiteResponseModel  $response
     * @return ViewModel
     */
    public function noSuchSite(DeleteSiteResponseModel $response): ViewModel;

    /**
     * @param  DeleteSiteResponseModel  $response
     * @return ViewModel
     */
    public function permissionException(DeleteSiteResponseModel $response): ViewModel;

    /**
     * @param  DeleteSiteResponseModel  $response
     * @param  \Throwable  $e
     * @return ViewModel
     */
    public function unableToDeleteSite(DeleteSiteResponseModel $response, \Throwable $e): ViewModel;
}
