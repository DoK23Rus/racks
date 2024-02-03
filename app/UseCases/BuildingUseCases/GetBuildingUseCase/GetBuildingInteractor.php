<?php

namespace App\UseCases\BuildingUseCases\GetBuildingUseCase;

use App\Domain\Interfaces\BuildingInterfaces\BuildingFactory;
use App\Domain\Interfaces\BuildingInterfaces\BuildingRepository;
use App\Domain\Interfaces\ViewModel;

class GetBuildingInteractor implements GetBuildingInputPort
{
    public function __construct(
        private readonly GetBuildingOutputPort $output,
        private readonly BuildingRepository $buildingRepository,
        private readonly BuildingFactory $buildingFactory
    ) {
    }

    public function getBuilding(GetBuildingRequestModel $request): ViewModel
    {
        $building = $this->buildingFactory->makeFromId($request->getId());

        try {
            $building = $this->buildingRepository->getById($building->getId());
        } catch (\Exception $e) {
            return $this->output->noSuchBuilding(
                App()->makeWith(GetBuildingResponseModel::class, ['building' => $building])
            );
        }

        return $this->output->retrieveBuilding(
            App()->makeWith(GetBuildingResponseModel::class, ['building' => $building])
        );
    }
}
