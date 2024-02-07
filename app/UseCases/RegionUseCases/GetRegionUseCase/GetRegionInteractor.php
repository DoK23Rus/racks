<?php

namespace App\UseCases\RegionUseCases\GetRegionUseCase;

use App\Domain\Interfaces\RegionInterfaces\RegionRepository;
use App\Domain\Interfaces\ViewModel;

class GetRegionInteractor implements GetRegionInputPort
{
    public function __construct(
        private readonly GetRegionOutputPort $output,
        private readonly RegionRepository $regionRepository
    ) {
    }

    public function getRegion(GetRegionRequestModel $request): ViewModel
    {
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
