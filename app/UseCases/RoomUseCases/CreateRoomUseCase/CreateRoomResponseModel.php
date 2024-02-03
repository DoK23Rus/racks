<?php

namespace App\UseCases\RoomUseCases\CreateRoomUseCase;

use App\Domain\Interfaces\RoomInterfaces\RoomEntity;

class CreateRoomResponseModel
{
    public function __construct(
        private readonly RoomEntity $room
    ) {
    }

    public function getRoom(): RoomEntity
    {
        return $this->room;
    }
}
