<?php

namespace App\Http\Requests;

class ReportPostRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "id" => [
                'required',
                'integer',
            ],
            "subject" => [
                'required',
                'string',
            ],
            "details" => [
                'required',
                'string',
            ],
        ];
    }
}
