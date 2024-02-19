<?php

namespace App\Domain\Interfaces\BuildingInterfaces;

use App\UseCases\BuildingUseCases\CreateBuildingUseCase\CreateBuildingRequestModel;
use App\UseCases\BuildingUseCases\UpdateBuildingUseCase\UpdateBuildingRequestModel;

interface BuildingFactory
{
    /**
     * @param  CreateBuildingRequestModel  $request
     * @return BuildingEntity|BuildingBusinessRules
     */
    public function makeFromCreateRequest(CreateBuildingRequestModel $request): BuildingEntity|BuildingBusinessRules;

    /**
     * @param  UpdateBuildingRequestModel  $request
     * @return BuildingEntity|BuildingBusinessRules
     */
    public function makeFromPatchRequest(UpdateBuildingRequestModel $request): BuildingEntity|BuildingBusinessRules;
}
