<?php

namespace App\UseCases\RoomUseCases\DeleteRoomUseCase;

use App\Domain\Interfaces\ViewModel;
use App\UseCases\RoomUseCases\CreateRoomUseCase\CreateRoomResponseModel;

interface DeleteRoomOutputPort
{
    public function roomDeleted(DeleteRoomResponseModel $response): ViewModel;

    public function noSuchRoom(DeleteRoomResponseModel $response): ViewModel;

    public function unableToDeleteRoom(DeleteRoomResponseModel $response, \Throwable $e): ViewModel;

    public function permissionException(CreateRoomResponseModel $response): ViewModel;
}
