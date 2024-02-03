<?php

namespace App\UseCases\RegionUseCases\CreateRegionUseCase;

use App\Domain\Interfaces\ViewModel;

interface CreateRegionOutputPort
{
    public function regionCreated(CreateRegionResponseModel $response): ViewModel;

    public function regionAlreadyExists(CreateRegionResponseModel $response): ViewModel;

    public function unableToCreateRegion(CreateRegionResponseModel $response, \Throwable $e): ViewModel;
}
