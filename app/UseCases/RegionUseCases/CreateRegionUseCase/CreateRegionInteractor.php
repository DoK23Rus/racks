<?php

namespace App\UseCases\RegionUseCases\CreateRegionUseCase;

use App\Domain\Interfaces\RegionInterfaces\RegionFactory;
use App\Domain\Interfaces\RegionInterfaces\RegionRepository;
use App\Domain\Interfaces\ViewModel;

class CreateRegionInteractor implements CreateRegionInputPort
{
    public function __construct(
        private readonly CreateRegionOutputPort $output,
        private readonly RegionRepository $regionRepository,
        private readonly RegionFactory $regionFactory,
    ) {
    }

    public function createRegion(CreateRegionRequestModel $request): ViewModel
    {
        $region = $this->regionFactory->makeFromCreateRequest($request);

        if ($this->regionRepository->exists($region)) {
            return $this->output->regionAlreadyExists(
                App()->makeWith(CreateRegionResponseModel::class, ['region' => $region])
            );
        }

        try {
            $region = $this->regionRepository->create($region);
        } catch (\Exception $e) {
            return $this->output->unableToCreateRegion(
                App()->makeWith(CreateRegionResponseModel::class, ['region' => $region]),
                $e
            );
        }

        return $this->output->regionCreated(
            App()->makeWith(CreateRegionResponseModel::class, ['region' => $region])
        );
    }
}
