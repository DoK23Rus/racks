<?php

namespace App\UseCases\RegionUseCases\DeleteRegionUseCase;

use App\Domain\Interfaces\RegionInterfaces\RegionFactory;
use App\Domain\Interfaces\RegionInterfaces\RegionRepository;
use App\Domain\Interfaces\ViewModel;

class DeleteRegionInteractor implements DeleteRegionInputPort
{
    public function __construct(
        private readonly DeleteRegionOutputPort $output,
        private readonly RegionRepository $regionRepository,
        private readonly RegionFactory $regionFactory,
    ) {
    }

    public function deleteRegion(DeleteRegionRequestModel $request): ViewModel
    {
        $region = $this->regionFactory->makeFromId($request->getId());

        try {
            $region = $this->regionRepository->getById($region->getId());
        } catch (\Exception $e) {
            return $this->output->noSuchRegion(
                App()->makeWith(DeleteRegionResponseModel::class, ['region' => $region])
            );
        }

        try {
            $this->regionRepository->delete($region);
        } catch (\Exception $e) {
            return $this->output->unableToDeleteRegion(
                App()->makeWith(DeleteRegionResponseModel::class, ['region' => $region]),
                $e
            );
        }

        return $this->output->regionDeleted(
            App()->makeWith(DeleteRegionResponseModel::class, ['region' => $region])
        );
    }
}
