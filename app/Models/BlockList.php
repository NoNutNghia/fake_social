<?php

namespace App\Models;

class BlockList extends BaseModel
{
    protected $fillable = [
        'user_id',
        'user_blocked_id'
    ];

    protected $table = 'block_list';
}
