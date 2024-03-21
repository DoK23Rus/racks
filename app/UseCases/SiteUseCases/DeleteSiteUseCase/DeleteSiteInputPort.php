<?php

namespace App\UseCases\SiteUseCases\DeleteSiteUseCase;

use App\Domain\Interfaces\ViewModel;

interface DeleteSiteInputPort
{
    /**
     * @param  DeleteSiteRequestModel  $request
     * @return ViewModel
     */
    public function deleteSite(DeleteSiteRequestModel $request): ViewModel;
}
