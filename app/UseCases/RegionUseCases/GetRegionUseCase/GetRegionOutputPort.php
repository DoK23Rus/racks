<?php

namespace App\UseCases\RegionUseCases\GetRegionUseCase;

use App\Domain\Interfaces\ViewModel;

interface GetRegionOutputPort
{
    /**
     * @param  GetRegionResponseModel  $response
     * @return ViewModel
     */
    public function retrieveRegion(GetRegionResponseModel $response): ViewModel;

    /**
     * @param  GetRegionResponseModel  $response
     * @return ViewModel
     */
    public function noSuchRegion(GetRegionResponseModel $response): ViewModel;
}
