<?php

namespace App\Http\Requests\RoomRequests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="UpdateRoomRequest",
 *     title="Update room request",
 *
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Room name",
 *         nullable=false,
 *         example="Some room"
 *     )
 *  )
 */
class UpdateRoomRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => ['prohibited'],
            'name' => ['required', 'string'],
            'department_id' => ['prohibited'],
        ];
    }
}
