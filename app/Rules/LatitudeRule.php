<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class LatitudeRule implements Rule
{

    private string $latitude;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($latitude)
    {
        $this->latitude = $latitude;
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
        return preg_match('/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/', $this->latitude);
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
