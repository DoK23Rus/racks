<?php

namespace App\UseCases\RoomUseCases\GetRoomUseCase;

use App\Domain\Interfaces\RoomInterfaces\RoomRepository;
use App\Domain\Interfaces\ViewModel;

class GetRoomInteractor implements GetRoomInputPort
{
    public function __construct(
        private readonly GetRoomOutputPort $output,
        private readonly RoomRepository $roomRepository
    ) {
    }

    public function getRoom(GetRoomRequestModel $request): ViewModel
    {
        try {
            $room = $this->roomRepository->getById($request->getId());
        } catch (\Exception $e) {
            return $this->output->noSuchRoom(
                App()->makeWith(GetRoomResponseModel::class, ['room' => null])
            );
        }

        return $this->output->retrieveRoom(
            App()->makeWith(GetRoomResponseModel::class, ['room' => $room])
        );
    }
}
