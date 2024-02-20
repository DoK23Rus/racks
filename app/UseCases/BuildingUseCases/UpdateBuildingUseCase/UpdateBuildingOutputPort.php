<?php

namespace App\UseCases\BuildingUseCases\UpdateBuildingUseCase;

use App\Domain\Interfaces\ViewModel;

interface UpdateBuildingOutputPort
{
    /**
     * @param  UpdateBuildingResponseModel  $response
     * @return ViewModel
     */
    public function buildingUpdated(UpdateBuildingResponseModel $response): ViewModel;

    /**
     * @param  UpdateBuildingResponseModel  $response
     * @return ViewModel
     */
    public function noSuchBuilding(UpdateBuildingResponseModel $response): ViewModel;

    /**
     * @param  UpdateBuildingResponseModel  $response
     * @return ViewModel
     */
    public function buildingNameException(UpdateBuildingResponseModel $response): ViewModel;

    /**
     * @param  UpdateBuildingResponseModel  $response
     * @param  \Throwable  $e
     * @return ViewModel
     */
    public function unableToUpdateBuilding(UpdateBuildingResponseModel $response, \Throwable $e): ViewModel;

    /**
     * @param  UpdateBuildingResponseModel  $response
     * @return ViewModel
     */
    public function permissionException(UpdateBuildingResponseModel $response): ViewModel;
}
