<?php

namespace App\Models;

class StatusUser extends BaseModel
{
    protected $fillable = [
        'status_name'
    ];

    protected $table = 'status_user';
}
