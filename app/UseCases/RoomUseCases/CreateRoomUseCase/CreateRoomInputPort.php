<?php

namespace App\UseCases\RoomUseCases\CreateRoomUseCase;

use App\Domain\Interfaces\ViewModel;

interface CreateRoomInputPort
{
    public function createRoom(CreateRoomRequestModel $request): ViewModel;
}
