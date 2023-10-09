<?php

namespace App\Models;

class Gender extends BaseModel
{
    protected $fillable = [
        'gender_name'
    ];

    protected $table = 'gender';
}
