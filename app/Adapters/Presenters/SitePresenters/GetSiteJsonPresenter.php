<?php

namespace App\Adapters\Presenters\SitePresenters;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Domain\Interfaces\ViewModel;
use App\Http\Resources\SiteResources\NoSuchSiteResource;
use App\Http\Resources\SiteResources\RetrieveSiteResource;
use App\UseCases\SiteUseCases\GetSiteUseCase\GetSiteOutputPort;
use App\UseCases\SiteUseCases\GetSiteUseCase\GetSiteResponseModel;

class GetSiteJsonPresenter implements GetSiteOutputPort
{
    public function retrieveSite(GetSiteResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    RetrieveSiteResource::class, ['site' => $response->getSite()]),
                'statusCode' => 200,
            ]
        );
    }

    public function noSuchSite(GetSiteResponseModel $response): ViewModel
    {
        return App()->makeWith(JsonResourceViewModel::class,
            [
                'resource' => App()->makeWith(
                    NoSuchSiteResource::class, ['site' => $response->getSite()]),
                'statusCode' => 404,
            ]
        );
    }
}
