<?php

namespace App\Http\Validators\Rules;

use Illuminate\Contracts\Validation\Rule;

class DeviceUnitsRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     */
    public function passes(mixed $attribute, mixed $value): bool
    {
        if (! is_array($value)) {
            return false;
        }
        if (! count($value)) {
            return false;
        }
        sort($value);
        $arrayCheck = range(
            array_values($value)[0],
            end($value),
            1
        );

        return $value === $arrayCheck;
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return 'The :attribute must be an array of range between last and first unit';
    }
}
