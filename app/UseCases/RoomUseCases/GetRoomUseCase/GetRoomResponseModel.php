<?php

namespace App\UseCases\RoomUseCases\GetRoomUseCase;

use App\Domain\Interfaces\RoomInterfaces\RoomEntity;

class GetRoomResponseModel
{
    /**
     * @param  RoomEntity|null  $room  Null for no such building response
     */
    public function __construct(
        private readonly ?RoomEntity $room
    ) {
    }

    /**
     * @return RoomEntity|null
     */
    public function getRoom(): ?RoomEntity
    {
        return $this->room;
    }
}
