<?php

namespace App\Models;

class Comment extends BaseModel
{
    protected $fillable = [
        'user_id',
        'mark_id',
        'content',
        'created_at',
    ];

    protected $hidden = [
        'mark_id',
    ];

    protected $table = 'comment';

    public function poster()
    {
        return $this->belongsTo(User::class,'user_id', 'id');
    }
}
