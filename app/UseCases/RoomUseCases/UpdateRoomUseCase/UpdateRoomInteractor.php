<?php

namespace App\UseCases\RoomUseCases\UpdateRoomUseCase;

use App\Domain\Interfaces\BuildingInterfaces\BuildingRepository;
use App\Domain\Interfaces\RoomInterfaces\RoomFactory;
use App\Domain\Interfaces\RoomInterfaces\RoomRepository;
use App\Domain\Interfaces\ViewModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class UpdateRoomInteractor implements UpdateRoomInputPort
{
    /**
     * @param  UpdateRoomOutputPort  $output
     * @param  RoomRepository  $roomRepository
     * @param  BuildingRepository  $buildingRepository
     * @param  RoomFactory  $roomFactory
     */
    public function __construct(
        private readonly UpdateRoomOutputPort $output,
        private readonly RoomRepository $roomRepository,
        private readonly BuildingRepository $buildingRepository,
        private readonly RoomFactory $roomFactory
    ) {
    }

    /**
     * @param  UpdateRoomRequestModel  $request
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function updateRoom(UpdateRoomRequestModel $request): ViewModel
    {
        $roomUpdating = $this->roomFactory->makeFromPutRequest($request);

        try {
            $room = $this->roomRepository->getById($roomUpdating->getId());
        } catch (\Exception $e) {
            return $this->output->noSuchRoom(
                App()->makeWith(UpdateRoomResponseModel::class, ['room' => $roomUpdating])
            );
        }

        $building = $this->buildingRepository->getById($room->getBuildingId());

        $roomUpdating = $this->roomFactory->makeFromPutRequest($request);

        if (! Gate::allows('departmentCheck', $room->getDepartmentId())) {
            return $this->output->permissionException(
                App()->makeWith(UpdateRoomResponseModel::class, ['room' => $roomUpdating])
            );
        }

        $roomUpdating->setUpdatedBy($request->getUserName());

        $roomUpdating->setOldName($room->getName());

        DB::beginTransaction();

        $this->roomRepository->lockTable();

        $roomNamesList = $this->roomRepository->getNamesListByBuildingId($building->getId());

        if (! $roomUpdating->isNameValid($roomNamesList) &&
            $roomUpdating->isNameChanging($roomUpdating->getOldName())) {
            return $this->output->roomNameException(
                App()->makeWith(UpdateRoomResponseModel::class, ['room' => $roomUpdating])
            );
        }

        try {
            $roomUpdating = $this->roomRepository->update($roomUpdating);
        } catch (\Exception $e) {
            return $this->output->unableToUpdateRoom(
                App()->makeWith(UpdateRoomResponseModel::class, ['room' => $roomUpdating]),
                $e
            );
        }

        DB::commit();

        Log::channel('action_log')->info("Update Room --> pk {$roomUpdating->getId()}", [
            'old_data' => $room->toArray(),
            'new_data' => $roomUpdating->toArray(),
            'by_user' => $request->getUserName(),
        ]);

        return $this->output->roomUpdated(
            App()->makeWith(UpdateRoomResponseModel::class, ['room' => $roomUpdating])
        );
    }
}
