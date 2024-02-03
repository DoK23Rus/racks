<?php

namespace App\UseCases\SiteUseCases\GetSiteUseCase;

use App\Domain\Interfaces\ViewModel;

interface GetSiteInputPort
{
    public function getSite(GetSiteRequestModel $request): ViewModel;
}
