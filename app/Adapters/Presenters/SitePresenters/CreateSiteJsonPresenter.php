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
