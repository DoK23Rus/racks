<?php

namespace App\UseCases\RegionUseCases\GetRegionUseCase;

use App\Domain\Interfaces\ViewModel;

interface GetRegionInputPort
{
    public function getRegion(GetRegionRequestModel $request): ViewModel;
}
