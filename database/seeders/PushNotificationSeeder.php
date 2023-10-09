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
            'noti_request' => true,
            'noti_post_by_myself' => true,
            'noti_comment' => true,
            'noti_react_post' => true,
            'noti_react_comment' => true,
            'noti_post_by_friend' => true,
        ));
    }
}
