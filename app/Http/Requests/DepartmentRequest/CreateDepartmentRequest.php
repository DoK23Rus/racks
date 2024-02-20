<?php

namespace App\Http\Requests\DepartmentRequest;

use Illuminate\Foundation\Http\FormRequest;

class CreateDepartmentRequest extends FormRequest
{
    /**
     * @return array<array<mixed>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'region_id' => ['required', 'integer', 'min:1'],
        ];
    }
}
