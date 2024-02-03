<?php

namespace App\UseCases\SiteUseCases\CreateSiteUseCase;

use App\Domain\Interfaces\ViewModel;

interface CreateSiteInputPort
{
    public function createSite(CreateSiteRequestModel $request): ViewModel;
}
