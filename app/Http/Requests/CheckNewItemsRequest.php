<?php

namespace App\Http\Requests;

class CheckNewItemsRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'last_id' => [
                'required',
                'integer'
            ],
            'category_id' => [
                'integer'
            ]
        ];
    }
}
