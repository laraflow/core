<?php

namespace Laraflow\Core\Rules;

use Illuminate\Contracts\Validation\Rule;

class Username implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     */
    public function passes($attribute, $value): bool
    {
        return (bool) preg_match('/^[a-zA-Z0-9\-\.]+$/i', $value);
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return 'This :attribute may only contain Letters, numbers, hyphen sign and dot.';
    }
}
