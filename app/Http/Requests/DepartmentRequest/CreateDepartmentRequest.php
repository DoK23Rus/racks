<?php

namespace App\Http\Requests\DepartmentRequest;

use Illuminate\Foundation\Http\FormRequest;

class CreateDepartmentRequest extends FormRequest
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
            'region_id' => ['required', 'integer', 'min:1'],
        ];
    }
}
