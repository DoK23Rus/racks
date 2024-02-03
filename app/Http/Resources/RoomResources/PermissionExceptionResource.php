<?php

namespace App\Http\Resources\RoomResources;

use App\Domain\Interfaces\RoomInterfaces\RoomEntity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionExceptionResource extends JsonResource
{
    protected RoomEntity $room;

    public function __construct(RoomEntity $room)
    {
        parent::__construct($room);
        $this->room = $room;
    }

    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'message' => 'Action not allowed for this department',
        ];
    }
}
