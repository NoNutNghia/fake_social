<?php

namespace App\Http\Requests;

use App\Rules\DevTokenRule;

class SetDevTokenRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "devType" => [
                'required',
                'integer',
                'min:0',
                'max:1',
            ],
            "devToken" => [
                'required',
                'string',
                new DevTokenRule($this["devToken"])
            ]
        ];
    }
}
