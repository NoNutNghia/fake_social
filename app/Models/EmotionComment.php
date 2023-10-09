<?php

namespace App\Models;

class EmotionComment extends BaseModel
{
    protected $fillable = [
        'user_id',
        'comment_id',
        'emotion_code',
        'created_at'
    ];
}
