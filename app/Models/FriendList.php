<?php

namespace App\Models;
class FriendList extends BaseModel
{
    protected $fillable = [
        'friend_id',
        'user_id'
    ];

    protected $table = 'friend_list';


}
