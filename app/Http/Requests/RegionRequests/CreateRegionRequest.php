<?php

namespace App\Http\Requests\RegionRequests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRegionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<array<mixed>>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
        ];
    }
}
