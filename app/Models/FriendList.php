<?php

namespace App\Models;
class FriendList extends BaseModel
{
    protected $fillable = [
        'friend_id',
        'user_id'
    ];

    protected $table = 'friend_list';

    protected $hidden = [
        'detail_friend'
    ];

    public function detail_friend()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
