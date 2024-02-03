<?php

namespace App\Http\Requests\UserRequests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<array>
     */
    public function rules()
    {
        return [
            'id' => ['required', 'integer', 'min:1'],
            'name' => ['required', 'string'],
            'full_name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users'],
            'department_id' => ['required', 'integer', 'min:1'],
        ];
    }
}
