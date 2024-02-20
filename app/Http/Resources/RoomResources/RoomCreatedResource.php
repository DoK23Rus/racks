<?php

namespace App\Http\Resources\RoomResources;

use App\Domain\Interfaces\RoomInterfaces\RoomEntity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="CreateRoomResponse",
 *     title="Room created",
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
class RoomCreatedResource extends JsonResource
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
            'building_id' => $this->room->getBuildingId(),
            'created_at' => $this->room->getCreatedAt(),
            'updated_at' => $this->room->getUpdatedAt(),
        ];
    }
}
