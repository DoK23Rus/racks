<?php

namespace App\Http\Requests\SiteRequests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="UpdateSiteRequest",
 *     title="Update site request",
 *
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Site name",
 *         nullable=false,
 *         example="Some site"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Site description",
 *         example="Site description"
 *     ),
 *  )
 */
class UpdateSiteRequest extends FormRequest
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
            'department_id' => ['prohibited'],
        ];
    }
}
