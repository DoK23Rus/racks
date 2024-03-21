<?php

namespace App\UseCases\RegionUseCases\UpdateRegionUseCase;

use App\Domain\Interfaces\ViewModel;

interface UpdateRegionOutputPort
{
    /**
     * @param  UpdateRegionResponseModel  $response
     * @return ViewModel
     */
    public function regionUpdated(UpdateRegionResponseModel $response): ViewModel;

    /**
     * @param  UpdateRegionResponseModel  $response
     * @return ViewModel
     */
    public function noSuchRegion(UpdateRegionResponseModel $response): ViewModel;

    /**
     * @param  UpdateRegionResponseModel  $response
     * @param  \Throwable  $e
     * @return ViewModel
     */
    public function unableToUpdateRegion(UpdateRegionResponseModel $response, \Throwable $e): ViewModel;
}
