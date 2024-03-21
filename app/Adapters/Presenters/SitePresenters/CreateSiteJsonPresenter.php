<?php

namespace App\Adapters\Presenters\SitePresenters;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Domain\Interfaces\ViewModel;
use App\Http\Resources\SiteResources\NoSuchDepartmentResource;
use App\Http\Resources\SiteResources\PermissionExceptionResource;
use App\Http\Resources\SiteResources\SiteCreatedResource;
use App\Http\Resources\SiteResources\UnableToCreateSiteResource;
use App\UseCases\SiteUseCases\CreateSiteUseCase\CreateSiteOutputPort;
use App\UseCases\SiteUseCases\CreateSiteUseCase\CreateSiteResponseModel;

class CreateSiteJsonPresenter implements CreateSiteOutputPort
{
    /**
     * @param  CreateSiteResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function siteCreated(CreateSiteResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    SiteCreatedResource::class, ['site' => $response->getSite()]),
                'statusCode' => 201,
            ]
        );
    }

    /**
     * @param  CreateSiteResponseModel  $response
     * @param  \Throwable  $e
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Throwable
     */
    public function unableToCreateSite(CreateSiteResponseModel $response, \Throwable $e): ViewModel
    {
        if (config('app.debug')) {
            throw $e;
        }

        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    UnableToCreateSiteResource::class, ['e' => $e]),
                'statusCode' => 500,
            ]
        );
    }

    /**
     * @param  CreateSiteResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function permissionException(CreateSiteResponseModel $response): ViewModel
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
     * @param  CreateSiteResponseModel  $response
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function noSuchDepartment(CreateSiteResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    NoSuchDepartmentResource::class, ['site' => $response->getSite()]),
                'statusCode' => 400,
            ]
        );
    }
}
