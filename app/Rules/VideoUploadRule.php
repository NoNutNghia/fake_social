<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class VideoUploadRule implements Rule
{

    private $videoList;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($videoList)
    {
        $this->videoList = $videoList;
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
        $approveExtension = ['mp4'];

        if ($this->videoList == null) return false;

        foreach ($this->videoList as $video) {
            if (!in_array($video->getClientOriginalExtension(), $approveExtension)) return false;
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
        return 'The validation error message.';
    }
}
