<?php

namespace App\UseCases\RegionUseCases\CreateRegionUseCase;

use App\Domain\Interfaces\ViewModel;

interface CreateRegionInputPort
{
    /**
     * @param  CreateRegionRequestModel  $request
     * @return ViewModel
     */
    public function createRegion(CreateRegionRequestModel $request): ViewModel;
}
