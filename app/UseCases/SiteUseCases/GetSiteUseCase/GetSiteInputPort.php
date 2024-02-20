<?php

namespace App\UseCases\SiteUseCases\GetSiteUseCase;

use App\Domain\Interfaces\ViewModel;

interface GetSiteInputPort
{
    /**
     * @param  GetSiteRequestModel  $request
     * @return ViewModel
     */
    public function getSite(GetSiteRequestModel $request): ViewModel;
}
