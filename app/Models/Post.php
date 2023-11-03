<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'described',
        'media',
        'post_status',
        'status'
    ];

    protected $table = 'post';

    public function containImages() {
//        return $this->hasMany()
    }
}
