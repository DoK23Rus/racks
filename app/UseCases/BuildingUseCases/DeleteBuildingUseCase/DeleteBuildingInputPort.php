<?php

namespace App\UseCases\BuildingUseCases\DeleteBuildingUseCase;

use App\Domain\Interfaces\ViewModel;

interface DeleteBuildingInputPort
{
    /**
     * @param  DeleteBuildingRequestModel  $request
     * @return ViewModel
     */
    public function deleteBuilding(DeleteBuildingRequestModel $request): ViewModel;
}
