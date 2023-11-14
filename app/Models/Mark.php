<?php

namespace App\Models;

class Mark extends BaseModel
{
    protected $fillable = [
        'user_id',
        'post_id',
        'mark_content',
        'type_of_mark',
        'created_at',
    ];

    protected $hidden = [
        'created_at',
    ];

    protected $table = 'mark';

    public function poster()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'mark_id', 'id');
    }
}
