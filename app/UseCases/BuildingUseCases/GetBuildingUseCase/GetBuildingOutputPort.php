<?php

namespace App\UseCases\BuildingUseCases\GetBuildingUseCase;

use App\Domain\Interfaces\ViewModel;

interface GetBuildingOutputPort
{
    /**
     * @param  GetBuildingResponseModel  $response
     * @return ViewModel
     */
    public function retrieveBuilding(GetBuildingResponseModel $response): ViewModel;

    /**
     * @param  GetBuildingResponseModel  $response
     * @return ViewModel
     */
    public function noSuchBuilding(GetBuildingResponseModel $response): ViewModel;
}
