<?php

namespace App\UseCases\BuildingUseCases\DeleteBuildingUseCase;

use App\Domain\Interfaces\ViewModel;

interface DeleteBuildingOutputPort
{
    /**
     * @param  DeleteBuildingResponseModel  $response
     * @return ViewModel
     */
    public function buildingDeleted(DeleteBuildingResponseModel $response): ViewModel;

    /**
     * @param  DeleteBuildingResponseModel  $response
     * @return ViewModel
     */
    public function noSuchBuilding(DeleteBuildingResponseModel $response): ViewModel;

    /**
     * @param  DeleteBuildingResponseModel  $response
     * @param  \Throwable  $e
     * @return ViewModel
     */
    public function unableToDeleteBuilding(DeleteBuildingResponseModel $response, \Throwable $e): ViewModel;

    /**
     * @param  DeleteBuildingResponseModel  $response
     * @return ViewModel
     */
    public function permissionException(DeleteBuildingResponseModel $response): ViewModel;
}
