<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetMarkCommentRequest extends BaseRequest
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
            'content_request' => [
                'required',
                'string',
            ],
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
            'mark_id' => [
                'integer',
                'min:0',
            ],
            'type' => [
                'integer',
                'min:0',
                'max:1'
            ],
        ];
    }
}
