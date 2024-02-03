<?php

namespace App\UseCases\RoomUseCases\DeleteRoomUseCase;

use App\Domain\Interfaces\ViewModel;

interface DeleteRoomInputPort
{
    public function deleteRoom(DeleteRoomRequestModel $request): ViewModel;
}
