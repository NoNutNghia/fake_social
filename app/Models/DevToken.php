<?php

namespace App\Models;

class DevToken extends BaseModel
{
    protected $fillable = [
        "devToken",
        "devType",
        "user_id",
        "created_at"
    ];

    protected $table = "devtoken";
}
