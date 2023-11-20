<?php

namespace App\Http\Requests;

use App\Rules\LatitudeLongitudeRule;
use App\Rules\LatitudeRule;
use App\Rules\LongitudeRule;

class GetListPostsRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => [
                'required',
                'integer'
            ],
            'in_campaign' => [
                'required',
                'integer',
                'min:0',
                'max:1'
            ],
            'campaign_id' => [
                'required',
                'integer'
            ],
            'latitude' => [
                'required',
                'string',
                new LatitudeRule($this['latitude'])
            ],
            'longitude' => [
                'required',
                'string',
                new LongitudeRule($this['longitude'])
            ],
            'last_id' => [
                'required',
                'integer'
            ],
            'index' => [
                'integer',
                'min:0'
            ],
            'count' => [
                'integer',
                'min:0',
            ]
        ];
    }
}
