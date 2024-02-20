<?php

namespace App\UseCases\RoomUseCases\DeleteRoomUseCase;

use App\Domain\Interfaces\RoomInterfaces\RoomRepository;
use App\Domain\Interfaces\ViewModel;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class DeleteRoomInteractor implements DeleteRoomInputPort
{
    /**
     * @param  DeleteRoomOutputPort  $output
     * @param  RoomRepository  $roomRepository
     */
    public function __construct(
        private readonly DeleteRoomOutputPort $output,
        private readonly RoomRepository $roomRepository
    ) {
    }

    /**
     * @param  DeleteRoomRequestModel  $request
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function deleteRoom(DeleteRoomRequestModel $request): ViewModel
    {
        try {
            $room = $this->roomRepository->getById($request->getId());
        } catch (\Exception $e) {
            return $this->output->noSuchRoom(
                App()->makeWith(DeleteRoomResponseModel::class, ['room' => null])
            );
        }

        if (! Gate::allows('departmentCheck', $room->getDepartmentId())) {
            return $this->output->permissionException(
                App()->makeWith(DeleteRoomResponseModel::class, ['room' => $room])
            );
        }

        try {
            $this->roomRepository->delete($room);
        } catch (\Exception $e) {
            return $this->output->unableToDeleteRoom(
                App()->makeWith(DeleteRoomResponseModel::class, ['room' => $room]),
                $e
            );
        }

        Log::channel('action_log')->info("Delete Room --> pk {$room->getId()}", [
            'deleted_data' => $room->toArray(),
            'by_user' => $request->getUserName(),
        ]);

        return $this->output->roomDeleted(
            App()->makeWith(DeleteRoomResponseModel::class, ['room' => $room])
        );
    }
}
