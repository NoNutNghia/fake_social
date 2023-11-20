<?php

namespace App\Http\Requests;

class GetUserFriendsRequest extends BaseRequest
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
                'integer'
            ],
            'index' => [
                'integer',
                'min:0',
            ],
            'count' => [
                'integer',
                'min:0',
            ]
        ];
    }
}
