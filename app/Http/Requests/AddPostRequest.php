<?php

namespace App\Http\Requests;

use App\Rules\ImageUploadRule;
use App\Rules\VideoUploadRule;

class AddPostRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "described" => ["string"],
            "status" => ["string"],
            "image" => [new ImageUploadRule($this->file('image'))],
            "video" => [new VideoUploadRule($this->file('video'))],
        ];
    }
}
