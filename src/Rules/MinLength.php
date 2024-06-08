<?php

namespace Laraflow\Core\Rules;

use Illuminate\Contracts\Validation\Rule;

class MinLength implements Rule
{
    private $limit;

    /**
     * Create a new rule instance.
     *
     * @param  int  $limit
     */
    public function __construct($limit)
    {
        $this->limit = intval($limit);
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     */
    public function passes($attribute, $value): bool
    {
        return ! (strlen($value) < $this->limit);
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return __('validation.minlength', ['limit' => $this->limit]);
    }
}
