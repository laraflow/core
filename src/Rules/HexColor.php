<?php

namespace Laraflow\Laraflow\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * Class HexColor
 * @package Laraflow\Laraflow\Rules
 */
class HexColor implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return (bool)preg_match("/^#[0-9a-f]{6,8}$/i", $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a valid hex color code.';
    }
}
