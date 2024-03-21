<?php

namespace App\Http\Resources\RoomResources;

use App\Domain\Interfaces\RoomInterfaces\RoomEntity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="NoSuchRoomForRoomResponse",
 *     title="No such room",
 *
 *         @OA\Property(
 *             property="message",
 *             type="string",
 *             example="No such room"
 *         )
 *     )
 * )
 */
class NoSuchRoomResource extends JsonResource
{
    /**
     * @var RoomEntity|null
     */
    protected ?RoomEntity $room;

    /**
     * @param  RoomEntity|null  $room
     */
    public function __construct(?RoomEntity $room)
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
            'message' => 'No such room',
        ];
    }
}
