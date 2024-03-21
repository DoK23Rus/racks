<?php

namespace App\Http\Requests\BuildingRequests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="UpdateBuildingRequest",
 *     title="Update building request",
 *
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Building name",
 *         nullable=false,
 *         example="Some building"
 *     ),
 *         @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Building description",
 *         example="Building description"
 *     ),
 *  )
 */
class UpdateBuildingRequest extends FormRequest
{
    /**
     * @return array<array<mixed>>
     */
    public function rules(): array
    {
        return [
            'id' => ['prohibited'],
            'name' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'site_id' => ['prohibited'],
        ];
    }
}
