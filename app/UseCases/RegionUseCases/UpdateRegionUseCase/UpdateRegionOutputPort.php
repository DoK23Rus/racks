<?php

namespace App\UseCases\RegionUseCases\UpdateRegionUseCase;

use App\Domain\Interfaces\ViewModel;

interface UpdateRegionOutputPort
{
    public function regionUpdated(UpdateRegionResponseModel $response): ViewModel;

    public function noSuchRegion(UpdateRegionResponseModel $response): ViewModel;

    public function unableToUpdateRegion(UpdateRegionResponseModel $response, \Throwable $e): ViewModel;
}
