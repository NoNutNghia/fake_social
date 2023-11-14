<?php

namespace App\Http\Requests;

class SetBlockRequest extends BaseRequest
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
                'integer',
            ],
            'type' => [
                'required',
                'integer',
                'min:0',
                'max:1',
            ],
        ];
    }
}
