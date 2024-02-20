<?php

namespace App\UseCases\RegionUseCases\CreateRegionUseCase;

use App\Domain\Interfaces\ViewModel;

interface CreateRegionOutputPort
{
    /**
     * @param  CreateRegionResponseModel  $response
     * @return ViewModel
     */
    public function regionCreated(CreateRegionResponseModel $response): ViewModel;

    /**
     * @param  CreateRegionResponseModel  $response
     * @return ViewModel
     */
    public function regionAlreadyExists(CreateRegionResponseModel $response): ViewModel;

    /**
     * @param  CreateRegionResponseModel  $response
     * @param  \Throwable  $e
     * @return ViewModel
     */
    public function unableToCreateRegion(CreateRegionResponseModel $response, \Throwable $e): ViewModel;
}
