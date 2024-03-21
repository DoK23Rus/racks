<?php

namespace App\UseCases\RegionUseCases\UpdateRegionUseCase;

use App\Domain\Interfaces\RegionInterfaces\RegionFactory;
use App\Domain\Interfaces\RegionInterfaces\RegionRepository;
use App\Domain\Interfaces\ViewModel;

class UpdateRegionInteractor implements UpdateRegionInputPort
{
    /**
     * @param  UpdateRegionOutputPort  $output
     * @param  RegionRepository  $regionRepository
     * @param  RegionFactory  $regionFactory
     */
    public function __construct(
        private readonly UpdateRegionOutputPort $output,
        private readonly RegionRepository $regionRepository,
        private readonly RegionFactory $regionFactory,
    ) {
    }

    /**
     * @param  UpdateRegionRequestModel  $request
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function updateRegion(UpdateRegionRequestModel $request): ViewModel
    {
        $regionUpdating = $this->regionFactory->makeFromPatchRequest($request);

        // Try to get region
        try {
            $region = $this->regionRepository->getById($regionUpdating->getId());
        } catch (\Exception $e) {
            return $this->output->noSuchRegion(
                App()->makeWith(UpdateRegionResponseModel::class, ['region' => $regionUpdating])
            );
        }

        // Try to update
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
