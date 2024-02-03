<?php

namespace App\UseCases\RegionUseCases\GetRegionUseCase;

use App\Domain\Interfaces\ViewModel;

interface GetRegionOutputPort
{
    public function retrieveRegion(GetRegionResponseModel $response): ViewModel;

    public function noSuchRegion(GetRegionResponseModel $response): ViewModel;
}
