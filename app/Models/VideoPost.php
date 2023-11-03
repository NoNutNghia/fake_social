<?php

namespace App\Models;

class VideoPost extends BaseModel
{
    protected $fillable = [
        'post_id',
        'url',
        'thumbnail',
        'created_at',
    ];

    protected $table = 'video_post';
}
