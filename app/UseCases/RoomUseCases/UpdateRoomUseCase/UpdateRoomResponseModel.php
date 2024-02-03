<?php

namespace App\UseCases\RoomUseCases\UpdateRoomUseCase;

use App\Domain\Interfaces\RoomInterfaces\RoomEntity;

class UpdateRoomResponseModel
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
