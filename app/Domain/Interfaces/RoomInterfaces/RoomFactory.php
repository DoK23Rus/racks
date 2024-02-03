<?php

namespace App\Domain\Interfaces\RoomInterfaces;

use App\UseCases\RoomUseCases\CreateRoomUseCase\CreateRoomRequestModel;
use App\UseCases\RoomUseCases\UpdateRoomUseCase\UpdateRoomRequestModel;

interface RoomFactory
{
    public function makeFromId(int $id): RoomEntity;

    public function makeFromCreateRequest(CreateRoomRequestModel $request): RoomEntity|RoomBusinessRules;

    public function makeFromPutRequest(UpdateRoomRequestModel $request): RoomEntity|RoomBusinessRules;
}
