<?php

namespace App\Models;

class Message extends BaseModel
{
    protected $fillable = [
        'sender_id',
        'conversation_id',
        'content',
        'un_read',
        'created_at'
    ];

    protected $table = 'message';

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }
}
