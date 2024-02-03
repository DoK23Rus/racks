<?php

namespace App\UseCases\RegionUseCases\GetRegionUseCase;

use App\Domain\Interfaces\RegionInterfaces\RegionFactory;
use App\Domain\Interfaces\RegionInterfaces\RegionRepository;
use App\Domain\Interfaces\ViewModel;

class GetRegionInteractor implements GetRegionInputPort
{
    public function __construct(
        private readonly GetRegionOutputPort $output,
        private readonly RegionRepository $regionRepository,
        private readonly RegionFactory $regionFactory
    ) {
    }

    public function getRegion(GetRegionRequestModel $request): ViewModel
    {
        $region = $this->regionFactory->makeFromId($request->getId());

        try {
            $region = $this->regionRepository->getById($region->getId());
        } catch (\Exception $e) {
            return $this->output->noSuchRegion(
                App()->makeWith(GetRegionResponseModel::class, ['region' => $region])
            );
        }

        return $this->output->retrieveRegion(
            App()->makeWith(GetRegionResponseModel::class, ['region' => $region])
        );
    }
}
