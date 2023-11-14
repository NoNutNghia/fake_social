<?php

namespace App\Models;

class Version extends BaseModel
{
    protected $fillable = [
        'version',
        'created_at',
    ];

    protected $hidden = [
        'id',
        'created_at'
    ];

    protected $table = 'version';
}
