<?php

namespace App\Http\Requests;

class GetConversationRequest extends BaseRequest
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
            ],
            'index' => [
                'integer',
                'min:0'
            ],
            'count' => [
                'integer',
                'min:0'
            ]
        ];
    }
}
