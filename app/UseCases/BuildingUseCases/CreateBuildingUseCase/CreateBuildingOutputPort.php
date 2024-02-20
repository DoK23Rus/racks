<?php

namespace App\UseCases\BuildingUseCases\CreateBuildingUseCase;

use App\Domain\Interfaces\ViewModel;

interface CreateBuildingOutputPort
{
    /**
     * @param  CreateBuildingResponseModel  $response
     * @return ViewModel
     */
    public function buildingCreated(CreateBuildingResponseModel $response): ViewModel;

    /**
     * @param  CreateBuildingResponseModel  $response
     * @return ViewModel
     */
    public function buildingNameException(CreateBuildingResponseModel $response): ViewModel;

    /**
     * @param  CreateBuildingResponseModel  $response
     * @return ViewModel
     */
    public function noSuchSite(CreateBuildingResponseModel $response): ViewModel;

    /**
     * @param  CreateBuildingResponseModel  $response
     * @param  \Throwable  $e
     * @return ViewModel
     */
    public function unableToCreateBuilding(CreateBuildingResponseModel $response, \Throwable $e): ViewModel;

    /**
     * @param  CreateBuildingResponseModel  $response
     * @return ViewModel
     */
    public function permissionException(CreateBuildingResponseModel $response): ViewModel;
}
