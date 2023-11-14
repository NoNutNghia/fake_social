<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ImageUploadRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    private $imageList;
    public function __construct($imageList)
    {
        $this->imageList = $imageList;
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
        $approveExtension = ['pdf', 'jpg', 'jpeg', 'png'];

        if ($this->imageList == null) return false;

        foreach ($this->imageList as $image) {
            if (!in_array($image->getClientOriginalExtension(), $approveExtension)) return false;
        }

        return true;
    }

    public function message()
    {
        // TODO: Implement message() method.
    }
}
