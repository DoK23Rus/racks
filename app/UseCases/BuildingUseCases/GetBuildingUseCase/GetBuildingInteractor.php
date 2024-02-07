<?php

namespace App\UseCases\BuildingUseCases\GetBuildingUseCase;

use App\Domain\Interfaces\BuildingInterfaces\BuildingRepository;
use App\Domain\Interfaces\ViewModel;

class GetBuildingInteractor implements GetBuildingInputPort
{
    public function __construct(
        private readonly GetBuildingOutputPort $output,
        private readonly BuildingRepository $buildingRepository
    ) {
    }

    public function getBuilding(GetBuildingRequestModel $request): ViewModel
    {
        try {
            $building = $this->buildingRepository->getById($request->getId());
        } catch (\Exception $e) {
            return $this->output->noSuchBuilding(
                App()->makeWith(GetBuildingResponseModel::class, ['building' => null])
            );
        }

        return $this->output->retrieveBuilding(
            App()->makeWith(GetBuildingResponseModel::class, ['building' => $building])
        );
    }
}
