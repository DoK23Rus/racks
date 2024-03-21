<?php

namespace App\UseCases\RoomUseCases\CreateRoomUseCase;

use App\Domain\Interfaces\RoomInterfaces\RoomEntity;

class CreateRoomResponseModel
{
    /**
     * @param  RoomEntity  $room
     */
    public function __construct(
        private readonly RoomEntity $room
    ) {
    }

    /**
     * @return RoomEntity
     */
    public function getRoom(): RoomEntity
    {
        return $this->room;
    }
}
