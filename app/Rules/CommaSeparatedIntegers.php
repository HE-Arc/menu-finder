<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CommaSeparatedIntegers implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Comma separated values to array
        $relation_ids = explode(',', $value);

        foreach ($relation_ids as $id) {
            // Each element should be a valid integer
            if (!filter_var($id, FILTER_VALIDATE_INT)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid value given; expected a list of comma separated value of integers.';
    }
}
