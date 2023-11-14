<?php

namespace App\Models;

class Search extends BaseModel
{
    protected $fillable = [
        'keyword',
        'user_id',
        'created_at'
    ];

    protected $hidden = [
        'user_id'
    ];

    protected $table = 'search';
}
