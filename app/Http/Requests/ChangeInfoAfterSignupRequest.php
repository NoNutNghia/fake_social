<?php

namespace App\Http\Requests;

use App\Rules\EmailRule;
use App\Rules\ImageUploadRule;
use App\Rules\UsernameRule;
use Illuminate\Foundation\Http\FormRequest;

class ChangeInfoAfterSignupRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "username" => [
                'required',
                'string',
                'min:6',
                'max:10',
                new UsernameRule($this["username"])
            ],
            "avatar" => [new ImageUploadRule($this->file('avatar'))],
        ];
    }
}
