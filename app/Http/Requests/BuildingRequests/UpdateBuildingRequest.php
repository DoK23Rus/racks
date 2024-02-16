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
 *     )
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
            'name' => ['required', 'string'],
            'site_id' => ['prohibited'],
        ];
    }
}
