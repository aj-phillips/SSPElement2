<?php

namespace App\Rules;

use DateTime;
use Illuminate\Contracts\Validation\Rule;

class DobAgeCheck implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    public $minAge = 18;

    public function __construct()
    {
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return (new DateTime)->diff(new DateTime($value))->y >= $this->minAge;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'You must be at least ' . $this->minAge . ' years old to register.';
    }
}
