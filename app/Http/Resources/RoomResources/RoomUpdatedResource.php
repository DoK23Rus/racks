<?php

namespace App\Http\Resources\RoomResources;

use App\Domain\Interfaces\RoomInterfaces\RoomEntity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="RoomUpdatedResponse",
 *     title="Update room",
 *
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         example="Room name"
 *     ),
 *     @OA\Property(
 *         property="building_floor",
 *         type="string",
 *         example="2nd"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         example="Room description"
 *     ),
 *     @OA\Property(
 *         property="number_of_rack_spaces",
 *         type="integer",
 *         example=8
 *     ),
 *     @OA\Property(
 *         property="area",
 *         type="integer",
 *         example=20
 *     ),
 *     @OA\Property(
 *         property="responsible",
 *         type="string",
 *         example="Some responsible"
 *     ),
 *     @OA\Property(
 *         property="cooling_system",
 *         type="string",
 *         enum={
 *             "Centralized",
 *             "Individual",
 *             "None",
 *         },
 *         example="Centralized"
 *     ),
 *     @OA\Property(
 *         property="fire_suppression_system",
 *         type="string",
 *         enum={
 *             "Centralized",
 *             "Individual",
 *             "None",
 *             "Alarm only",
 *         },
 *         example="Centralized"
 *     ),
 *     @OA\Property(
 *         property="access_is_open",
 *         type="boolean",
 *         example=false
 *     ),
 *     @OA\Property(
 *         property="has_raised_floor",
 *         type="boolean",
 *         example=false
 *     ),
 *     @OA\Property(
 *         property="building_id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="department_id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="updated_by",
 *         type="string",
 *         example="Some user"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         example="2024-01-28 16:32:21"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         example="2024-01-28 16:32:21"
 *     )
 * )
 */
class RoomUpdatedResource extends JsonResource
{
    /**
     * @var RoomEntity
     */
    protected RoomEntity $room;

    /**
     * @param  RoomEntity  $room
     */
    public function __construct(RoomEntity $room)
    {
        parent::__construct($room);
        $this->room = $room;
    }

    /**
     * @param  Request  $request
     * @return array<mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->room->getId(),
            'name' => $this->room->getName(),
            'building_floor' => $this->room->getBuildingFloor(),
            'description' => $this->room->getDescription(),
            'number_of_rack_spaces' => $this->room->getNumberOfRackSpaces(),
            'area' => $this->room->getArea(),
            'responsible' => $this->room->getResponsible(),
            'cooling_system' => $this->room->getCoolingSystem(),
            'fire_suppression_system' => $this->room->getFireSuppressionSystem(),
            'access_is_open' => $this->room->getAccessIsOpen(),
            'has_raised_floor' => $this->room->getHasRaisedFloor(),
            'updated_by' => $this->room->getUpdatedBy(),
            'created_at' => $this->room->getCreatedAt(),
            'updated_at' => $this->room->getUpdatedAt(),
        ];
    }
}
