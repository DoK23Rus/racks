<?php

namespace App\Http\Requests\BuildingRequests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="CreateBuildingRequest",
 *     title="Create building request",
 *
 *     @OA\Property(
 *         property="site_id",
 *         type="integer",
 *         description="Site ID",
 *         nullable=false,
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Building name",
 *         nullable=false,
 *         example="Some building"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Building description",
 *         example="Building description"
 *     ),
 *  )
 */
class CreateBuildingRequest extends FormRequest
{
    /**
     * @return array<array<mixed>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'site_id' => ['required', 'int'],
        ];
    }
}
