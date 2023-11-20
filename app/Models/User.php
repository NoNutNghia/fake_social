<?php

namespace App\Models;

use App\Enum\RequestStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'avatar',
        'coins',
        'status_user',
        'role',
        'password',
        'gender',
        'phone',
        'country',
        'city',
        'link',
        'cover_image',
        'description',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'updated_at',
        'status_user',
        'role',
        'password',
        'gender',
        'list_user_blocked',
        'phone',
        'email_verified_at',
        'uuid',
        'list_friends',
        'list_user_blocked',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userPushNotification()
    {
        return $this->hasOne(PushNotification::class, 'user_id', 'id');
    }

    public function listVerifyCode()
    {
        return $this->hasMany(VerifyCode::class, 'user_id', 'id');
    }

    public function list_user_blocked()
    {
        return $this->hasMany(BlockList::class, 'user_id', 'id');
    }

    public function sendRequestFriend()
    {
        return $this->hasMany(RequestFriend::class, 'user_id', 'id')
            ->where('request_status', RequestStatusEnum::USER_PENDING);
    }

    public function pushNotification()
    {
        return $this->hasOne(PushNotification::class,'user_id', 'id');
    }

    public function list_friends()
    {
        return $this->hasMany(FriendList::class, 'user_id', 'id');
    }

    public function dev_token()
    {
        return $this->hasMany(DevToken::class, 'user_id', 'id');
    }
}
