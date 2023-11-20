<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DevTokenRule implements Rule
{

    private string $devToken;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($devToken)
    {
        $this->devToken = trim($devToken);
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
        return $this->devToken;
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
