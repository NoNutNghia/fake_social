<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarkedPost extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id'
    ];

    protected $table = 'marked_post';
}
