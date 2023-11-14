<?php

namespace App\Http\Requests;

class GetPostRequest extends BaseRequest
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
            ]
        ];
    }
}
