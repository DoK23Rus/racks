<?php

namespace App\UseCases\SiteUseCases\UpdateSiteUseCase;

use App\Domain\Interfaces\ViewModel;

interface UpdateSiteInputPort
{
    public function updateSite(UpdateSiteRequestModel $request): ViewModel;
}
