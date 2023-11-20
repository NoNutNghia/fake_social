<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteMessageRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'message_id' => [
                'required',
                'integer'
            ],
            'conversation_id' => [
                'required',
                'integer'
            ],
            'partner_id' => [
                'required',
                'integer'
            ]
        ];
    }
}
