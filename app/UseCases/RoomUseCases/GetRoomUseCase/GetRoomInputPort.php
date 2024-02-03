<?php

namespace App\UseCases\RoomUseCases\GetRoomUseCase;

use App\Domain\Interfaces\ViewModel;

interface GetRoomInputPort
{
    public function getRoom(GetRoomRequestModel $request): ViewModel;
}
