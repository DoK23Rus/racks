<?php

namespace App\UseCases\RegionUseCases\UpdateRegionUseCase;

use App\Domain\Interfaces\ViewModel;

interface UpdateRegionInputPort
{
    /**
     * @param  UpdateRegionRequestModel  $request
     * @return ViewModel
     */
    public function updateRegion(UpdateRegionRequestModel $request): ViewModel;
}
