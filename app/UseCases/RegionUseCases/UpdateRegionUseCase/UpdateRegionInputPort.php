<?php

namespace App\UseCases\RegionUseCases\UpdateRegionUseCase;

use App\Domain\Interfaces\ViewModel;

interface UpdateRegionInputPort
{
    public function updateRegion(UpdateRegionRequestModel $request): ViewModel;
}
