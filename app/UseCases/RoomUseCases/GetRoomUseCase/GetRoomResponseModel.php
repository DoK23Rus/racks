<?php

namespace App\UseCases\RoomUseCases\GetRoomUseCase;

use App\Domain\Interfaces\RoomInterfaces\RoomEntity;

class GetRoomResponseModel
{
    public function __construct(
        private readonly ?RoomEntity $room
    ) {
    }

    public function getRoom(): ?RoomEntity
    {
        return $this->room;
    }
}
