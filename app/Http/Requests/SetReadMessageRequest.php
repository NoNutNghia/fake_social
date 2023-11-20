<?php

namespace App\Http\Requests;

class SetReadMessageRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'partner_id' => [
                'required',
                'integer'
            ],
            'conversation_id' => [
                'required',
                'integer'
            ]
        ];
    }
}
