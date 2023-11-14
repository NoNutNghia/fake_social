<?php

namespace Database\Seeders;

use App\Models\PushNotification;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PushNotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PushNotification::create(array(
            'user_id' => 1,
            'like_comment' => true,
            'from_friends' => true,
            'requested_friends' => true,
            'suggested_friend' => true,
            'birthday' => true,
            'video' => true,
            'report' => true,
            'sound_on' => true,
            'notification_on' => true,
            'vibrant_on' => true,
            'led_on' => true,
        ));
        PushNotification::create(array(
            'user_id' => 2,
            'like_comment' => true,
            'from_friends' => true,
            'requested_friends' => true,
            'suggested_friend' => true,
            'birthday' => true,
            'video' => true,
            'report' => true,
            'sound_on' => true,
            'notification_on' => true,
            'vibrant_on' => true,
            'led_on' => true,
        ));
    }
}
