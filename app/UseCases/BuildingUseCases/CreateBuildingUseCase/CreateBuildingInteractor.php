<?php

namespace App\UseCases\BuildingUseCases\CreateBuildingUseCase;

use App\Domain\Interfaces\BuildingInterfaces\BuildingFactory;
use App\Domain\Interfaces\BuildingInterfaces\BuildingRepository;
use App\Domain\Interfaces\SiteInterfaces\SiteFactory;
use App\Domain\Interfaces\SiteInterfaces\SiteRepository;
use App\Domain\Interfaces\ViewModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class CreateBuildingInteractor implements CreateBuildingInputPort
{
    public function __construct(
        private readonly CreateBuildingOutputPort $output,
        private readonly BuildingRepository $buildingRepository,
        private readonly SiteRepository $siteRepository,
        private readonly BuildingFactory $buildingFactory,
        private readonly SiteFactory $siteFactory
    ) {
    }

    public function createBuilding(CreateBuildingRequestModel $request): ViewModel
    {
        $building = $this->buildingFactory->makeFromCreateRequest($request);

        $site = $this->siteFactory->makeFromId($request->getSiteId());

        try {
            $site = $this->siteRepository->getById($site->getId());
        } catch (\Exception $e) {
            return $this->output->noSuchSite(
                App()->makeWith(CreateBuildingResponseModel::class, ['building' => $building])
            );
        }

        if (! Gate::allows('departmentCheck', $site->getDepartmentId())) {
            return $this->output->permissionException(
                App()->makeWith(CreateBuildingResponseModel::class, ['building' => $building])
            );
        }

        $building->setUpdatedBy($request->getUserName());

        $building->setDepartmentId($site->getDepartmentId());

        DB::beginTransaction();

        $this->buildingRepository->lockTable();

        if (! $building->isNameValid($this->buildingRepository->getNamesListBySiteId($site->getId()))) {
            return $this->output->buildingNameException(
                App()->makeWith(CreateBuildingResponseModel::class, ['building' => $building])
            );
        }

        try {
            $building = $this->buildingRepository->create($building);
        } catch (\Exception $e) {
            return $this->output->unableToCreateBuilding(
                App()->makeWith(CreateBuildingResponseModel::class, ['building' => $building]),
                $e
            );
        }

        DB::commit();

        Log::channel('action_log')->info("Create Building --> fk {$site->getId()}", [
            'new_data' => $building->toArray(),
            'by_user' => $request->getUserName(),
        ]);

        return $this->output->buildingCreated(
            App()->makeWith(CreateBuildingResponseModel::class, ['building' => $building])
        );
    }
}
