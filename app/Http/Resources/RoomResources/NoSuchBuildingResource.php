<?php

namespace App\Http\Resources\RoomResources;

use App\Domain\Interfaces\RoomInterfaces\RoomEntity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="NoSuchBuildingForRoomResponse",
 *     title="No such building",
 *
 *         @OA\Property(
 *             property="message",
 *             type="string",
 *             example="No such building"
 *         )
 *     )
 * )
 */
class NoSuchBuildingResource extends JsonResource
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
            'message' => 'No such building',
        ];
    }
}
