<?php

namespace App\UseCases\RoomUseCases\UpdateRoomUseCase;

use App\Domain\Interfaces\ViewModel;

interface UpdateRoomInputPort
{
    public function updateRoom(UpdateRoomRequestModel $request): ViewModel;
}
