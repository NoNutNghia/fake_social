<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PushNotification extends Model
{
    use HasFactory;

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
