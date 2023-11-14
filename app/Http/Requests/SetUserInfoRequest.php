<?php

namespace App\Http\Requests;

use App\Rules\ImageUploadRule;
class SetUserInfoRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => [
                'string'
            ],
            'description' => [
                'string',
                'max:150'
            ],
            'avatar' => [
                new ImageUploadRule($this->file('avatar')),
            ],
            'address' => [
                'string'
            ],
            'city' => [
                'string'
            ],
            'country' => [
                'string'
            ],
            'cover_image' => [
                new ImageUploadRule($this->file('cover_image')),
            ],
            'link' => [
                'string'
            ]
        ];
    }
}
