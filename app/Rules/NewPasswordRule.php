<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NewPasswordRule implements Rule
{

    private string $password;

    private string $newPassword;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($password, $newPassword)
    {
        $this->password = trim($password);
        $this->newPassword = trim($newPassword);
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

        if ($this->password)

        return !($this->password === $this->newPassword);
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
