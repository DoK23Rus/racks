<?php

namespace App\UseCases\RoomUseCases\DeleteRoomUseCase;

use App\Domain\Interfaces\RoomInterfaces\RoomEntity;

class DeleteRoomResponseModel
{
    /**
     * @param  RoomEntity|null  $room  Null for no such room response
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
