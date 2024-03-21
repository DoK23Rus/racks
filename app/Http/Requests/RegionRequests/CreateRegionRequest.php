<?php

namespace App\Http\Requests\RegionRequests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRegionRequest extends FormRequest
{
    /**
     * @return array<array<mixed>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
        ];
    }
}
