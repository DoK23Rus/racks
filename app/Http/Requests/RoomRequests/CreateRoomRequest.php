<?php

namespace App\Http\Requests\RoomRequests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="CreateRoomRequest",
 *     title="Create room request",
 *
 *     @OA\Property(
 *         property="building_id",
 *         type="integer",
 *         description="Building ID",
 *         nullable=false,
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Room name",
 *         nullable=false,
 *         example="Some room"
 *     )
 *  )
 */
class CreateRoomRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<array>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'building_id' => ['required', 'int'],
        ];
    }
}
