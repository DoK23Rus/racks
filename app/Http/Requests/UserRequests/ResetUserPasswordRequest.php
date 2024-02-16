<?php

namespace App\Http\Requests\UserRequests;

use App\Models\ValueObjects\PasswordValueObject;
use Illuminate\Foundation\Http\FormRequest;

class ResetUserPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<array<mixed>>
     */
    public function rules(): array
    {
        return [
            'id' => ['required', 'integer', 'min:1'],
            'password' => ['required', 'string', 'regex:'.PasswordValueObject::VALIDATION_REGEX],
        ];
    }
}
