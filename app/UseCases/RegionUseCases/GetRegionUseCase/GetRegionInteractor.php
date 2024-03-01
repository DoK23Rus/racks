<?php

namespace App\UseCases\RegionUseCases\GetRegionUseCase;

use App\Domain\Interfaces\RegionInterfaces\RegionRepository;
use App\Domain\Interfaces\ViewModel;

class GetRegionInteractor implements GetRegionInputPort
{
    /**
     * @param  GetRegionOutputPort  $output
     * @param  RegionRepository  $regionRepository
     */
    public function __construct(
        private readonly GetRegionOutputPort $output,
        private readonly RegionRepository $regionRepository
    ) {
    }

    /**
     * @param  GetRegionRequestModel  $request
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getRegion(GetRegionRequestModel $request): ViewModel
    {
        // Try to get region
        try {
            $region = $this->regionRepository->getById($request->getId());
        } catch (\Exception $e) {
            return $this->output->noSuchRegion(
                App()->makeWith(GetRegionResponseModel::class, ['region' => null])
            );
        }

        return $this->output->retrieveRegion(
            App()->makeWith(GetRegionResponseModel::class, ['region' => $region])
        );
    }
}
