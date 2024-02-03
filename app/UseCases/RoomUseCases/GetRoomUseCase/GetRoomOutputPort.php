<?php

namespace App\UseCases\RoomUseCases\GetRoomUseCase;

use App\Domain\Interfaces\ViewModel;

interface GetRoomOutputPort
{
    public function retrieveRoom(GetRoomResponseModel $response): ViewModel;

    public function noSuchRoom(GetRoomResponseModel $response): ViewModel;
}
