<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetRequestFriend extends BaseRequest
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
        ];
    }
}
