<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteSavedSearchRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'search_id' => [
                'required',
                'integer',
                'min:0',
            ],
            'all' => [
                'required',
                'integer',
                'min:0',
                'max:1',
            ]
        ];
    }
}
