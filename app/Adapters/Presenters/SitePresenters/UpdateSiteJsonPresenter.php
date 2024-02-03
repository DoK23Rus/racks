<?php

namespace App\Adapters\Presenters\SitePresenters;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Domain\Interfaces\ViewModel;
use App\Http\Resources\SiteResources\NoSuchDepartmentResource;
use App\Http\Resources\SiteResources\PermissionExceptionResource;
use App\Http\Resources\SiteResources\SiteUpdatedResource;
use App\Http\Resources\SiteResources\UnableToUpdateSiteResource;
use App\UseCases\SiteUseCases\UpdateSiteUseCase\UpdateSiteOutputPort;
use App\UseCases\SiteUseCases\UpdateSiteUseCase\UpdateSiteResponseModel;

class UpdateSiteJsonPresenter implements UpdateSiteOutputPort
{
    public function siteUpdated(UpdateSiteResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    SiteUpdatedResource::class, ['site' => $response->getSite()]),
                'statusCode' => 202,
            ]
        );
    }

    public function noSuchSite(UpdateSiteResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    NoSuchDepartmentResource::class, ['site' => $response->getSite()]),
                'statusCode' => 404,
            ]
        );
    }

    public function permissionException(UpdateSiteResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    PermissionExceptionResource::class, ['site' => $response->getSite()]),
                'statusCode' => 403,
            ]
        );
    }

    public function unableToUpdateSite(UpdateSiteResponseModel $response, \Throwable $e): ViewModel
    {
        if (config('app.debug')) {
            throw $e;
        }

        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    UnableToUpdateSiteResource::class, ['e' => $e]),
                'statusCode' => 500,
            ]
        );
    }
}
