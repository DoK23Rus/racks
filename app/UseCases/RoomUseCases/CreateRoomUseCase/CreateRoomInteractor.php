<?php

namespace App\UseCases\RoomUseCases\CreateRoomUseCase;

use App\Domain\Interfaces\BuildingInterfaces\BuildingRepository;
use App\Domain\Interfaces\RoomInterfaces\RoomFactory;
use App\Domain\Interfaces\RoomInterfaces\RoomRepository;
use App\Domain\Interfaces\ViewModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class CreateRoomInteractor implements CreateRoomInputPort
{
    /**
     * @param  CreateRoomOutputPort  $output
     * @param  BuildingRepository  $buildingRepository
     * @param  RoomRepository  $roomRepository
     * @param  RoomFactory  $roomFactory
     */
    public function __construct(
        private readonly CreateRoomOutputPort $output,
        private readonly BuildingRepository $buildingRepository,
        private readonly RoomRepository $roomRepository,
        private readonly RoomFactory $roomFactory
    ) {
    }

    /**
     * @param  CreateRoomRequestModel  $request
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function createRoom(CreateRoomRequestModel $request): ViewModel
    {
        $room = $this->roomFactory->makeFromCreateRequest($request);

        try {
            $building = $this->buildingRepository->getById($request->getBuildingId());
        } catch (\Exception $e) {
            return $this->output->noSuchBuilding(
                App()->makeWith(CreateRoomResponseModel::class, ['room' => $room])
            );
        }

        if (! Gate::allows('departmentCheck', $building->getDepartmentId())) {
            return $this->output->permissionException(
                App()->makeWith(CreateRoomResponseModel::class, ['room' => $room])
            );
        }

        $room->setUpdatedBy($request->getUserName());

        $room->setDepartmentId($building->getDepartmentId());

        DB::beginTransaction();

        $this->roomRepository->lockTable();

        if (! $room->isNameValid($this->roomRepository->getNamesListByBuildingId($building->getId()))) {
            return $this->output->roomNameException(
                App()->makeWith(CreateRoomResponseModel::class, ['room' => $room])
            );
        }

        try {
            $room = $this->roomRepository->create($room);
        } catch (\Exception $e) {
            return $this->output->unableToCreateRoom(
                App()->makeWith(CreateRoomResponseModel::class, ['room' => $room]),
                $e
            );
        }

        DB::commit();

        Log::channel('action_log')->info("Create Room --> fk {$building->getId()}", [
            'new_data' => $room->toArray(),
            'by_user' => $request->getUserName(),
        ]);

        return $this->output->roomCreated(
            App()->makeWith(CreateRoomResponseModel::class, ['room' => $room])
        );
    }
}
