<?php

namespace App\Models;

class RatingPost extends BaseModel
{
    protected $fillable = [
        'user_id',
        'post_id',
        'rating',
        'created_at'
    ];

    protected $table = 'rating_post';
}
