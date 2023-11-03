<?php

namespace App\Models;

class VerifyCode extends BaseModel
{
    protected $fillable = [
        'user_id',
        'expiry_at',
        'usage_status',
        'token',
    ];

    protected $table = 'verify_code';

    public function belongUser() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
