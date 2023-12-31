<?php

namespace App\Http\Requests;
class GetListBlocksRequest extends BaseRequest
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
                'integer',
                'min:0',
            ],
            'count' => [
                'integer',
                'min:0',
            ],
        ];
    }
}
