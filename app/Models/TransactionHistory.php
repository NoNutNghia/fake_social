<?php

namespace App\Models;

class TransactionHistory extends BaseModel
{
    protected $fillable = [
        'user_id',
        'transaction_content',
        'created_at'
    ];
}
