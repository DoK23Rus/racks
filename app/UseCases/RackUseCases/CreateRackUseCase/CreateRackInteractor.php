<?php

namespace App\UseCases\RackUseCases\CreateRackUseCase;

use App\Domain\Interfaces\RackInterfaces\RackFactory;
use App\Domain\Interfaces\RackInterfaces\RackRepository;
use App\Domain\Interfaces\RoomInterfaces\RoomFactory;
use App\Domain\Interfaces\RoomInterfaces\RoomRepository;
use App\Domain\Interfaces\ViewModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class CreateRackInteractor implements CreateRackInputPort
{
    public function __construct(
        private readonly CreateRackOutputPort $output,
        private readonly RackRepository $rackRepository,
        private readonly RoomRepository $roomRepository,
        private readonly RackFactory $rackFactory,
        private readonly RoomFactory $roomFactory
    ) {
    }

    public function createRack(CreateRackRequestModel $request): ViewModel
    {
        $rack = $this->rackFactory->makeFromCreateRequest($request);

        $room = $this->roomFactory->makeFromId($request->getRoomId());

        try {
            $room = $this->roomRepository->getById($room->getId());
        } catch (\Exception $e) {
            return $this->output->noSuchRoom(
                App()->makeWith(CreateRackResponseModel::class, ['rack' => $rack])
            );
        }

        if (! Gate::allows('departmentCheck', $room->getDepartmentId())) {
            return $this->output->permissionException(
                App()->makeWith(CreateRackResponseModel::class, ['rack' => $rack])
            );
        }

        $rack->setUpdatedBy($request->getUserName());

        $rack->setDepartmentId($room->getDepartmentId());

        DB::beginTransaction();

        $this->rackRepository->lockTable();

        if (! $rack->isNameValid($this->rackRepository->getNamesListByRoomId($room->getId()))) {
            return $this->output->rackNameException(
                App()->makeWith(CreateRackResponseModel::class, ['rack' => $rack])
            );
        }

        try {
            $rack = $this->rackRepository->create($rack);
        } catch (\Exception $e) {
            return $this->output->unableToCreateRack(
                App()->makeWith(CreateRackResponseModel::class, ['rack' => $rack]),
                $e
            );
        }

        DB::commit();

        Log::channel('action_log')->info("Create Rack --> fk {$room->getId()}", [
            'new_data' => $rack->toArray(),
            'by_user' => $request->getUserName(),
        ]);

        return $this->output->rackCreated(
            App()->makeWith(CreateRackResponseModel::class, ['rack' => $rack])
        );
    }
}
