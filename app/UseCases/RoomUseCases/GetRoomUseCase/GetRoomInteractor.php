<?php

namespace App\UseCases\RoomUseCases\GetRoomUseCase;

use App\Domain\Interfaces\RoomInterfaces\RoomFactory;
use App\Domain\Interfaces\RoomInterfaces\RoomRepository;
use App\Domain\Interfaces\ViewModel;

class GetRoomInteractor implements GetRoomInputPort
{
    public function __construct(
        private readonly GetRoomOutputPort $output,
        private readonly RoomRepository $roomRepository,
        private readonly RoomFactory $roomFactory
    ) {
    }

    public function getRoom(GetRoomRequestModel $request): ViewModel
    {
        $room = $this->roomFactory->makeFromId($request->getId());

        try {
            $room = $this->roomRepository->getById($room->getId());
        } catch (\Exception $e) {
            return $this->output->noSuchRoom(
                App()->makeWith(GetRoomResponseModel::class, ['room' => $room])
            );
        }

        return $this->output->retrieveRoom(
            App()->makeWith(GetRoomResponseModel::class, ['room' => $room])
        );
    }
}
