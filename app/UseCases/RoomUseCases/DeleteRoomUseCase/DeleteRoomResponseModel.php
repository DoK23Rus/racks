<?php

namespace App\UseCases\RoomUseCases\DeleteRoomUseCase;

use App\Domain\Interfaces\RoomInterfaces\RoomEntity;

class DeleteRoomResponseModel
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
