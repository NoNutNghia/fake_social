<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'object_id',
        'title',
        'created_at',
        'avatar',
        'group',
        'read'
    ];

    protected $hidden = [
        'user_id'
    ];

    protected $table = 'notification';
}
