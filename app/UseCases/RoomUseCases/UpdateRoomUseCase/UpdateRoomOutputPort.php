<?php

namespace App\UseCases\RoomUseCases\UpdateRoomUseCase;

use App\Domain\Interfaces\ViewModel;

interface UpdateRoomOutputPort
{
    public function roomUpdated(UpdateRoomResponseModel $response): ViewModel;

    public function noSuchRoom(UpdateRoomResponseModel $response): ViewModel;

    public function roomNameException(UpdateRoomResponseModel $response): ViewModel;

    public function unableToUpdateRoom(UpdateRoomResponseModel $response, \Throwable $e): ViewModel;

    public function permissionException(UpdateRoomResponseModel $response): ViewModel;
}
