<?php

namespace App\UseCases\RegionUseCases\CreateRegionUseCase;

use App\Domain\Interfaces\ViewModel;

interface CreateRegionInputPort
{
    public function createRegion(CreateRegionRequestModel $request): ViewModel;
}
