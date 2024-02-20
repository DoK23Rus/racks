<?php

namespace App\Adapters\Presenters\SitePresenters;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Domain\Interfaces\ViewModel;
use App\Http\Resources\SiteResources\NoSuchSiteResource;
use App\Http\Resources\SiteResources\PermissionExceptionResource;
use App\Http\Resources\SiteResources\SiteDeletedResource;
use App\Http\Resources\SiteResources\UnableToDeleteSiteResource;
use App\UseCases\SiteUseCases\DeleteSiteUseCase\DeleteSiteOutputPort;
use App\UseCases\SiteUseCases\DeleteSiteUseCase\DeleteSiteResponseModel;

class DeleteSiteJsonPresenter implements DeleteSiteOutputPort
{
    /**
     * @param  DeleteSiteResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function siteDeleted(DeleteSiteResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    SiteDeletedResource::class, ['site' => $response->getSite()]),
                'statusCode' => 204,
            ]
        );
    }

    /**
     * @param  DeleteSiteResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function noSuchSite(DeleteSiteResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    NoSuchSiteResource::class, ['site' => $response->getSite()]),
                'statusCode' => 404,
            ]
        );
    }

    /**
     * @param  DeleteSiteResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function permissionException(DeleteSiteResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    PermissionExceptionResource::class, ['site' => $response->getSite()]),
                'statusCode' => 403,
            ]
        );
    }

    /**
     * @param  DeleteSiteResponseModel  $response
     * @param  \Throwable  $e
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Throwable
     */
    public function unableToDeleteSite(DeleteSiteResponseModel $response, \Throwable $e): ViewModel
    {
        if (config('app.debug')) {
            throw $e;
        }

        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    UnableToDeleteSiteResource::class, ['e' => $e]),
                'statusCode' => 500,
            ]
        );
    }
}
