<?php

namespace App\UseCases\BuildingUseCases\UpdateBuildingUseCase;

use App\Domain\Interfaces\BuildingInterfaces\BuildingFactory;
use App\Domain\Interfaces\BuildingInterfaces\BuildingRepository;
use App\Domain\Interfaces\SiteInterfaces\SiteRepository;
use App\Domain\Interfaces\ViewModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class UpdateBuildingInteractor implements UpdateBuildingInputPort
{
    public function __construct(
        private readonly UpdateBuildingOutputPort $output,
        private readonly BuildingRepository $buildingRepository,
        private readonly SiteRepository $siteRepository,
        private readonly BuildingFactory $buildingFactory
    ) {
    }

    public function updateBuilding(UpdateBuildingRequestModel $request): ViewModel
    {
        $buildingUpdating = $this->buildingFactory->makeFromPatchRequest($request);

        try {
            $building = $this->buildingRepository->getById($buildingUpdating->getId());
        } catch (\Exception $e) {
            return $this->output->noSuchBuilding(
                App()->makeWith(UpdateBuildingResponseModel::class, ['building' => $buildingUpdating])
            );
        }

        $site = $this->siteRepository->getById($buildingUpdating->getSiteId());

        if (! Gate::allows('departmentCheck', $building->getDepartmentId())) {
            return $this->output->permissionException(
                App()->makeWith(UpdateBuildingResponseModel::class, ['building' => $buildingUpdating])
            );
        }

        $buildingUpdating->setUpdatedBy($request->getUserName());

        DB::beginTransaction();

        $this->buildingRepository->lockTable();

        if (! $buildingUpdating->isNameValid($this->buildingRepository->getNamesListBySiteId($site->getId()))) {
            return $this->output->buildingNameException(
                App()->makeWith(UpdateBuildingResponseModel::class, ['building' => $buildingUpdating])
            );
        }

        try {
            $buildingUpdating = $this->buildingRepository->update($buildingUpdating);
        } catch (\Exception $e) {
            return $this->output->unableToUpdateBuilding(
                App()->makeWith(UpdateBuildingResponseModel::class, ['building' => $buildingUpdating]),
                $e
            );
        }

        DB::commit();

        Log::channel('action_log')->info("Update Building --> pk {$building->getId()}", [
            'old_data' => $building->toArray(),
            'new_data' => $buildingUpdating->toArray(),
            'by_user' => $request->getUserName(),
        ]);

        return $this->output->buildingUpdated(
            App()->makeWith(UpdateBuildingResponseModel::class, ['building' => $buildingUpdating])
        );
    }
}
