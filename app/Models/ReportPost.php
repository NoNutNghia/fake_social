<?php

namespace App\Models;

class ReportPost extends BaseModel
{
    protected $fillable = [
        'user_id',
        'post_id',
        'subject',
        'details',
        'created_at',
    ];

    protected $table = 'report_post';
}
