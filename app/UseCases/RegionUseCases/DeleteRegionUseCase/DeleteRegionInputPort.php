<?php

namespace App\UseCases\RegionUseCases\DeleteRegionUseCase;

use App\Domain\Interfaces\ViewModel;

interface DeleteRegionInputPort
{
    public function deleteRegion(DeleteRegionRequestModel $request): ViewModel;
}
