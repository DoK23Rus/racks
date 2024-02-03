<?php

namespace App\UseCases\RegionUseCases\UpdateRegionUseCase;

use App\Domain\Interfaces\RegionInterfaces\RegionFactory;
use App\Domain\Interfaces\RegionInterfaces\RegionRepository;
use App\Domain\Interfaces\ViewModel;

class UpdateRegionInteractor implements UpdateRegionInputPort
{
    public function __construct(
        private readonly UpdateRegionOutputPort $output,
        private readonly RegionRepository $regionRepository,
        private readonly RegionFactory $regionFactory,
    ) {
    }

    public function updateRegion(UpdateRegionRequestModel $request): ViewModel
    {
        $regionUpdating = $this->regionFactory->makeFromPutRequest($request);

        try {
            $region = $this->regionRepository->getById($regionUpdating->getId());
        } catch (\Exception $e) {
            return $this->output->noSuchRegion(
                App()->makeWith(UpdateRegionResponseModel::class, ['region' => $regionUpdating])
            );
        }

        try {
            $regionUpdating = $this->regionRepository->update($regionUpdating);
        } catch (\Exception $e) {
            return $this->output->unableToUpdateRegion(
                App()->makeWith(UpdateRegionResponseModel::class, ['region' => $regionUpdating]),
                $e
            );
        }

        return $this->output->regionUpdated(
            App()->makeWith(UpdateRegionResponseModel::class, ['region' => $regionUpdating])
        );
    }
}
