<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportComment extends BaseModel
{
    protected $fillable = [
        'user_id',
        'comment_id',
        'content',
        'created_at',
    ];

    protected $table = 'report_comment';
}
