<?php

namespace App\Http\Requests\SiteRequests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="CreateSiteRequest",
 *     title="Create site request",
 *
 *     @OA\Property(
 *         property="department_id",
 *         type="integer",
 *         description="Department ID",
 *         nullable=false,
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Site name",
 *         nullable=false,
 *         example="Some site"
 *     )
 *  )
 */
class CreateSiteRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<array<mixed>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'department_id' => ['required', 'int'],
        ];
    }
}
