<?php

namespace App\Models;

class Role extends BaseModel
{
    protected $fillable = [
        'role_name'
    ];

    protected $table = 'role';
}
