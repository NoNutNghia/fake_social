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

    public function image() {
        return $this->hasMany(ImagePost::class, 'post_id', 'id');
    }

    public function video() {
        return $this->hasMany(VideoPost::class, 'post_id', 'id');
    }

    public function haveRating() {
        return $this->hasMany(RatingPost::class, 'post_id', 'id');
    }

    public function haveMark() {
        return $this->hasMany(Mark::class, 'post_id', 'id');
    }

    public function authorPost() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
