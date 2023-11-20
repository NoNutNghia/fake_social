<?php

namespace App\Models;

class Conversation extends BaseModel
{
    protected $fillable = [
        'partner_id',
        'user_id',
        'created_at',
    ];

    protected $table = 'conversation';

    protected $hidden = [
        'list_messages'
    ];

    public function partner()
    {
        return $this->hasOne(User::class, 'id', 'partner_id');
    }

    public function list_messages()
    {
        return $this->hasMany(Message::class,'conversation_id', 'id');
    }
}
