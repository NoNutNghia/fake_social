<?php

namespace App\Models;

class RequestFriend extends BaseModel
{
    protected $fillable = [
        'user_id',
        'target_id',
        'request_type',
        'request_status',
    ];

    protected $table = 'request_friend';
}
