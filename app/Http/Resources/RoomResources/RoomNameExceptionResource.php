<?php

namespace App\Http\Resources\RoomResources;

use App\Domain\Interfaces\RoomInterfaces\RoomEntity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="RoomNameExceptionResponse",
 *     title="Room with this name already exists in this building",
 *
 *         @OA\Property(
 *              property="message",
 *              type="string",
 *              example="Room with this name already exists in this building"
 *         )
 *     )
 * )
 */
class RoomNameExceptionResource extends JsonResource
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
            'message' => 'Room with this name already exists in this building',
        ];
    }
}
