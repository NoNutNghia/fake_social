<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteConversationRequest extends FormRequest
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
