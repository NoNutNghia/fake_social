<?php

namespace App\Http\Requests;

class SetPushSettingsRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'like_comment' => [
                'required',
                'integer',
                'min:0',
                'max:1',
            ],
            'from_friends' => [
                'required',
                'integer',
                'min:0',
                'max:1',
            ],
            'requested_friends' => [
                'required',
                'integer',
                'min:0',
                'max:1',
            ],
            'suggested_friend' => [
                'required',
                'integer',
                'min:0',
                'max:1',
            ],
            'birthday' => [
                'required',
                'integer',
                'min:0',
                'max:1',
            ],
            'video' => [
                'required',
                'integer',
                'min:0',
                'max:1',
            ],
            'report' => [
                'required',
                'integer',
                'min:0',
                'max:1',
            ],
            'sound_on' => [
                'required',
                'integer',
                'min:0',
                'max:1',
            ],
            'notification_on' => [
                'required',
                'integer',
                'min:0',
                'max:1',
            ],
            'vibrant_on' => [
                'required',
                'integer',
                'min:0',
                'max:1',
            ],
            'led_on' => [
                'required',
                'integer',
                'min:0',
                'max:1',
            ]
        ];
    }
}
