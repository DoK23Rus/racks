<?php

namespace App\UseCases\BuildingUseCases\GetBuildingUseCase;

use App\Domain\Interfaces\BuildingInterfaces\BuildingRepository;
use App\Domain\Interfaces\ViewModel;

class GetBuildingInteractor implements GetBuildingInputPort
{
    /**
     * @param  GetBuildingOutputPort  $output
     * @param  BuildingRepository  $buildingRepository
     */
    public function __construct(
        private readonly GetBuildingOutputPort $output,
        private readonly BuildingRepository $buildingRepository
    ) {
    }

    /**
     * @param  GetBuildingRequestModel  $request
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getBuilding(GetBuildingRequestModel $request): ViewModel
    {
        // Try to get building
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
