<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PushNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'like_comment',
        'from_friends',
        'requested_friends',
        'suggested_friend',
        'birthday',
        'video',
        'report',
        'sound_on',
        'notification_on',
        'vibrant_on',
        'led_on',
    ];

    protected $hidden = [
        'id',
        'user_id',
        'created_at',
        'updated_at',
    ];

    protected $table = 'push_noti';
}
