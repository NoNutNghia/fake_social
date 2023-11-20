<?php

namespace App\Http\Requests;

use App\Rules\ImageUploadRule;
use App\Rules\VideoUploadRule;

class EditPostRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => [
                'required',
                'integer',
            ],
            'described' => [
                'string'
            ],
            'status' => [
                'string'
            ],
            'image' => [
                new ImageUploadRule($this['image'])
            ],
            'image_del' => [
                'array'
            ],
            'image_sort' => [
                'array'
            ],
            'video' => [
                new VideoUploadRule($this['video'])
            ],
            'auto_accept' => [
                'integer',
                'min:0',
                'max:1',
            ]
        ];
    }
}
