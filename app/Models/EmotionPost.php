<?php

namespace App\Models;

class EmotionPost extends BaseModel
{
    protected $fillable = [
        'user_id',
        'post_id',
        'emotion_code',
        'created_at'
    ];

    protected $table = 'emotion_post';
}
