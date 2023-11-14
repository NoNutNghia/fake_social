<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeelRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "id" => [
                'required',
                'integer',
            ],
            "type" => [
                'required',
                'integer',
                'min:0',
                'max:1'
            ],
        ];
    }
}
