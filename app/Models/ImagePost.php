<?php

namespace App\Models;

class ImagePost extends BaseModel
{
    protected $fillable = [
        'url',
        'post_id',
        'sort_index',
        'created_at'
    ];

    protected $table = 'image_post';
}
