<?php

namespace App\UseCases\RackUseCases\UpdateRackUseCase;

use App\Domain\Interfaces\RackInterfaces\RackFactory;
use App\Domain\Interfaces\RackInterfaces\RackRepository;
use App\Domain\Interfaces\RoomInterfaces\RoomRepository;
use App\Domain\Interfaces\ViewModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class UpdateRackInteractor implements UpdateRackInputPort
{
    public function __construct(
        private readonly UpdateRackOutputPort $output,
        private readonly RackRepository $rackRepository,
        private readonly RoomRepository $roomRepository,
        private readonly RackFactory $rackFactory
    ) {
    }

    public function updateRack(UpdateRackRequestModel $request): ViewModel
    {
        $rackUpdating = $this->rackFactory->makeFromPatchRequest($request);

        try {
            $rack = $this->rackRepository->getById($rackUpdating->getId());
        } catch (\Exception $e) {
            return $this->output->noSuchRack(
                App()->makeWith(UpdateRackResponseModel::class, ['rack' => $rackUpdating])
            );
        }

        if (! Gate::allows('departmentCheck', $rack->getDepartmentId())) {
            return $this->output->permissionException(
                App()->makeWith(UpdateRackResponseModel::class, ['rack' => $rackUpdating])
            );
        }

        $rackUpdating->setUpdatedBy($request->getUserName());

        $rackUpdating->setId($rack->getId());

        $rackUpdating->setRoomId($rack->getRoomId());

        $rackUpdating->setOldName($rack->getName());

        $room = $this->roomRepository->getById($rack->getRoomId());

        DB::beginTransaction();

        $this->rackRepository->lockTable();

        $rackNamesList = $this->rackRepository->getNamesListByRoomId($room->getId());

        if (! $rack->isNameValid($rackNamesList) && $rack->isNameChanging($rackUpdating->getOldName())) {
            return $this->output->rackNameException(
                App()->makeWith(UpdateRackResponseModel::class, ['rack' => $rackUpdating])
            );
        }

        try {
            $rackUpdating = $this->rackRepository->update($rackUpdating);
        } catch (\Exception $e) {
            return $this->output->unableToUpdateRack(
                App()->makeWith(UpdateRackResponseModel::class, ['rack' => $rackUpdating]),
                $e
            );
        }

        DB::commit();

        Log::channel('action_log')->info("Update Rack --> pk {$rackUpdating->getId()}", [
            'old_data' => $rack->toArray(),
            'new_data' => $rackUpdating->toArray(),
            'by_user' => $request->getUserName(),
        ]);

        return $this->output->rackUpdated(
            App()->makeWith(UpdateRackResponseModel::class, ['rack' => $rackUpdating])
        );
    }
}
