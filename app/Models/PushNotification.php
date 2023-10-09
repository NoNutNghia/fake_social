<?php

namespace App\Models;

class PushNotification extends BaseModel
{
    protected $fillable = [
        'user_id',
        'noti_request',
        'noti_post_by_myself',
        'noti_comment',
        'noti_react_post',
        'noti_react_comment',
        'noti_post_by_friend',
    ];

    protected $table = 'push_noti';
}
