<?php

namespace App\UseCases\BuildingUseCases\DeleteBuildingUseCase;

use App\Domain\Interfaces\BuildingInterfaces\BuildingFactory;
use App\Domain\Interfaces\BuildingInterfaces\BuildingRepository;
use App\Domain\Interfaces\ViewModel;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class DeleteBuildingInteractor implements DeleteBuildingInputPort
{
    public function __construct(
        private readonly DeleteBuildingOutputPort $output,
        private readonly BuildingRepository $buildingRepository,
        private readonly BuildingFactory $buildingFactory
    ) {
    }

    public function deleteBuilding(DeleteBuildingRequestModel $request): ViewModel
    {
        $building = $this->buildingFactory->makeFromId($request->getId());

        try {
            $building = $this->buildingRepository->getById($building->getId());
        } catch (\Exception $e) {
            return $this->output->noSuchBuilding(
                App()->makeWith(DeleteBuildingResponseModel::class, ['building' => $building])
            );
        }

        if (! Gate::allows('departmentCheck', $building->getDepartmentId())) {
            return $this->output->permissionException(
                App()->makeWith(DeleteBuildingResponseModel::class, ['building' => $building])
            );
        }

        try {
            $this->buildingRepository->delete($building);
        } catch (\Exception $e) {
            return $this->output->unableToDeleteBuilding(
                App()->makeWith(DeleteBuildingResponseModel::class, ['building' => $building]),
                $e
            );
        }

        Log::channel('action_log')->info("Delete Building --> pk {$building->getId()}", [
            'deleted_data' => $building->toArray(),
            'by_user' => $request->getUserName(),
        ]);

        return $this->output->buildingDeleted(
            App()->makeWith(DeleteBuildingResponseModel::class, ['building' => $building])
        );
    }
}
