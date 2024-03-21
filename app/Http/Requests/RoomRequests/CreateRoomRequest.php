<?php

namespace App\Http\Requests\RoomRequests;

use App\Models\Enums\RoomCoolingSystemEnum;
use App\Models\Enums\RoomFireSuppressionSystemEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
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
 *     ),
 *     @OA\Property(
 *         property="building_floor",
 *         type="string",
 *         nullable=false,
 *         description="Room floor number",
 *         example="2nd"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Room description",
 *         example="Room description"
 *     ),
 *     @OA\Property(
 *         property="number_of_rack_spaces",
 *         type="integer",
 *         description="Number of rack spaces",
 *         example=8
 *     ),
 *     @OA\Property(
 *         property="area",
 *         type="integer",
 *         description="Room area (sq. m)",
 *         example=20
 *     ),
 *     @OA\Property(
 *         property="responsible",
 *         type="string",
 *         description="Responsible",
 *         example="Some responsible"
 *     ),
 *     @OA\Property(
 *         property="cooling_system",
 *         type="string",
 *         description="Cooling system",
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
 *         description="Fire suppression system",
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
 *         description="Room access is open?",
 *         example=false
 *     ),
 *     @OA\Property(
 *         property="has_raised_floor",
 *         type="boolean",
 *         description="Room has raised floor?",
 *         example=false
 *     ),
 *  )
 */
class CreateRoomRequest extends FormRequest
{
    /**
     * @return array<array<mixed>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'building_id' => ['required', 'int'],
            'building_floor' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'number_of_rack_spaces' => ['nullable', 'int'],
            'area' => ['nullable', 'int'],
            'cooling_system' => ['nullable', Rule::enum(RoomCoolingSystemEnum::class)],
            'fire_suppression_system' => ['nullable', Rule::enum(RoomFireSuppressionSystemEnum::class)],
            'access_is_open' => ['nullable', 'boolean'],
            'has_raised_floor' => ['nullable', 'boolean'],
            'responsible' => ['nullable', 'string'],
        ];
    }

    /**
     * @return array<array<mixed>>
     */
    public function messages(): array
    {
        return [
            'cooling_system' => ['Centralized', 'Individual', 'None'],
            'fire_suppression_system' => ['Centralized', 'Individual', 'None', 'Alarm only'],
        ];
    }
}
