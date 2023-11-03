<?php

namespace App\Http\Requests;

use App\Rules\EmailRule;

class SignupRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "email" => [
                'required',
                'string',
                new EmailRule($this["email"])
            ],
            "password" => [
                'required',
                'string',
                'min:6',
            ],
            "uuid" => [
                'required',
                'string'
            ]
        ];
    }
}
