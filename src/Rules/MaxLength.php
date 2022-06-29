<?php

namespace Laraflow\Core\Rules;

use Illuminate\Contracts\Validation\Rule;

class MaxLength implements Rule
{
    private $limit = null;

    /**
     * Create a new rule instance.
     *
     * @param int $limit
     */
    public function __construct($limit)
    {
        $this->limit = intval($limit);
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return (!(strlen($value) > $this->limit));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return __('validation.maxlength', ['limit' => $this->limit]);
    }
}
