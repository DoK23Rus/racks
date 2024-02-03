<?php

namespace App\Http\Requests\UserRequests;

use App\Models\ValueObjects\PasswordValueObject;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'full_name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'string', 'regex:'.PasswordValueObject::VALIDATION_REGEX],
            'department_id' => ['required', 'integer', 'min:1'],
        ];
    }
}
