<?php

namespace App\UseCases\SiteUseCases\DeleteSiteUseCase;

use App\Domain\Interfaces\ViewModel;

interface DeleteSiteInputPort
{
    public function deleteSite(DeleteSiteRequestModel $request): ViewModel;
}
