<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestFriend extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'target_id',
        'request_status',
    ];

    protected $table = 'request_friend';

    public function detailUser()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
