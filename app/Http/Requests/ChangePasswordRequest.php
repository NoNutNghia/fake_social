<?php

namespace App\Http\Requests;

use App\Rules\NewPasswordRule;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "password" => [
                'required',
                'string',
                'min:6',
            ],
            "new_password" => [
                'required',
                'string',
                'min:6',
                new NewPasswordRule($this["password"], $this["new_password"])
            ]
        ];
    }
}
