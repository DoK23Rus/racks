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
 *     )
 *  )
 */
class UpdateSiteRequest extends FormRequest
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
