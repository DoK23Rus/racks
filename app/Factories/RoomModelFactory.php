<?php

namespace App\Factories;

use App\Domain\Interfaces\RoomInterfaces\RoomBusinessRules;
use App\Domain\Interfaces\RoomInterfaces\RoomEntity;
use App\Domain\Interfaces\RoomInterfaces\RoomFactory;
use App\Models\Room;
use App\UseCases\RoomUseCases\CreateRoomUseCase\CreateRoomRequestModel;
use App\UseCases\RoomUseCases\UpdateRoomUseCase\UpdateRoomRequestModel;

class RoomModelFactory implements RoomFactory
{
    public function makeFromCreateRequest(CreateRoomRequestModel $request): RoomEntity|RoomBusinessRules
    {
        return new Room([
            'name' => $request->getName(),
            'building_id' => $request->getBuildingId(),
        ]);
    }

    public function makeFromPutRequest(UpdateRoomRequestModel $request): RoomEntity|RoomBusinessRules
    {
        return new Room([
            'id' => $request->getId(),
            'name' => $request->getName(),
        ]);
    }
}
