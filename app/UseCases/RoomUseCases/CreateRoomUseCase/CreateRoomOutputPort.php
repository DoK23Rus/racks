<?php

namespace App\UseCases\RoomUseCases\CreateRoomUseCase;

use App\Domain\Interfaces\ViewModel;

interface CreateRoomOutputPort
{
    public function roomCreated(CreateRoomResponseModel $response): ViewModel;

    public function noSuchBuilding(CreateRoomResponseModel $response): ViewModel;

    public function roomNameException(CreateRoomResponseModel $response): ViewModel;

    public function unableToCreateRoom(CreateRoomResponseModel $response, \Throwable $e): ViewModel;

    public function permissionException(CreateRoomResponseModel $response): ViewModel;
}
