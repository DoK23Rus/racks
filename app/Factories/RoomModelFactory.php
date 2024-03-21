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
    /**
     * @param  CreateRoomRequestModel  $request
     * @return RoomEntity|RoomBusinessRules
     */
    public function makeFromCreateRequest(CreateRoomRequestModel $request): RoomEntity|RoomBusinessRules
    {
        return new Room([
            'name' => $request->getName(),
            'building_id' => $request->getBuildingId(),
            'building_floor' => $request->getBuildingFloor(),
            'description' => $request->getDescription(),
            'number_of_rack_spaces' => $request->getNumberOfRackSpaces(),
            'area' => $request->getArea(),
            'responsible' => $request->getResponsible(),
            'cooling_system' => $request->getCoolingSystem(),
            'fire_suppression_system' => $request->getFireSuppressionSystem(),
            'access_is_open' => $request->getAccessIsOpen(),
            'has_raised_floor' => $request->getHasRaisedFloor(),
        ]);
    }

    /**
     * @param  UpdateRoomRequestModel  $request
     * @return RoomEntity|RoomBusinessRules
     */
    public function makeFromPutRequest(UpdateRoomRequestModel $request): RoomEntity|RoomBusinessRules
    {
        return new Room([
            'id' => $request->getId(),
            'name' => $request->getName(),
            'building_id' => $request->getBuildingId(),
            'department_id' => $request->getDepartmentId(),
            'building_floor' => $request->getBuildingFloor(),
            'description' => $request->getDescription(),
            'number_of_rack_spaces' => $request->getNumberOfRackSpaces(),
            'area' => $request->getArea(),
            'responsible' => $request->getResponsible(),
            'cooling_system' => $request->getCoolingSystem(),
            'fire_suppression_system' => $request->getFireSuppressionSystem(),
            'access_is_open' => $request->getAccessIsOpen(),
            'has_raised_floor' => $request->getHasRaisedFloor(),
        ]);
    }
}
