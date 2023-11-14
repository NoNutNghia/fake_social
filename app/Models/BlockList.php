<?php

namespace App\Models;

class BlockList extends BaseModel
{
    protected $fillable = [
        'user_id',
        'user_blocked_id'
    ];

    protected $table = 'block_list';

    protected $hidden = [
        'created_at'
    ];

    public function detailUser()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
