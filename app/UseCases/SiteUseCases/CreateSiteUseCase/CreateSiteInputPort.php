<?php

namespace App\UseCases\SiteUseCases\CreateSiteUseCase;

use App\Domain\Interfaces\ViewModel;

interface CreateSiteInputPort
{
    /**
     * @param  CreateSiteRequestModel  $request
     * @return ViewModel
     */
    public function createSite(CreateSiteRequestModel $request): ViewModel;
}
