<?php

namespace App\UseCases\RegionUseCases\DeleteRegionUseCase;

use App\Domain\Interfaces\ViewModel;

interface DeleteRegionOutputPort
{
    public function regionDeleted(DeleteRegionResponseModel $response): ViewModel;

    public function noSuchRegion(DeleteRegionResponseModel $response): ViewModel;

    public function unableToDeleteRegion(DeleteRegionResponseModel $response, \Throwable $e): ViewModel;
}
