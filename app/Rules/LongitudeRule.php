<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class LongitudeRule implements Rule
{
    private string $longitude;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($longitude)
    {
        $this->longitude = $longitude;
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
        return preg_match('/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/', $this->longitude);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
