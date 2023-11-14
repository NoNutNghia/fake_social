<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetMarkCommentRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'index' => [
                'required',
                'integer',
                'min:0',
            ],
            'count' => [
                'required',
                'integer',
                'min:0',
            ],
        ];
    }
}
