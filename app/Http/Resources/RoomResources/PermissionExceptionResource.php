<?php

namespace App\Http\Resources\RoomResources;

use App\Domain\Interfaces\RoomInterfaces\RoomEntity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionExceptionResource extends JsonResource
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
            'message' => 'Action not allowed for this department',
        ];
    }
}
