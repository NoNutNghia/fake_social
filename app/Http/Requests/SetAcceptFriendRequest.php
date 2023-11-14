<?php

namespace App\Http\Requests;

class SetAcceptFriendRequest extends BaseRequest
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
            'is_accepted' => [
                'required',
                'integer',
                'min:0',
                'max:1',
            ]
        ];
    }
}
