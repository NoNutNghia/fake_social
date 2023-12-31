<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchPostRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => [
                'required',
                'integer'
            ],
            'keyword' => [
                'required',
                'string',
            ],
            'index' => [
                'integer',
                'min:0'
            ],
            'count' => [
                'integer',
                'min:0'
            ]
        ];
    }
}
