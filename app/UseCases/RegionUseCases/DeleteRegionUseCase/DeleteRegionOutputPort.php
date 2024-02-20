<?php

namespace App\UseCases\RegionUseCases\DeleteRegionUseCase;

use App\Domain\Interfaces\ViewModel;

interface DeleteRegionOutputPort
{
    /**
     * @param  DeleteRegionResponseModel  $response
     * @return ViewModel
     */
    public function regionDeleted(DeleteRegionResponseModel $response): ViewModel;

    /**
     * @param  DeleteRegionResponseModel  $response
     * @return ViewModel
     */
    public function noSuchRegion(DeleteRegionResponseModel $response): ViewModel;

    /**
     * @param  DeleteRegionResponseModel  $response
     * @param  \Throwable  $e
     * @return ViewModel
     */
    public function unableToDeleteRegion(DeleteRegionResponseModel $response, \Throwable $e): ViewModel;
}
