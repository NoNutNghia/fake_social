<?php

namespace Database\Seeders;

use App\Enum\NotificationTypeEnum;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('notification')->insert(array(
            array(
                'title' => "New post is uploaded by lmao",
                'user_id' => 1,
                'object_id' => 1,
                'type' => NotificationTypeEnum::NEW_POST,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
            array(
                'title' => "Your post is felt by lmao bruh",
                'user_id' => 1,
                'object_id' => 1,
                'type' => NotificationTypeEnum::FEEL_POST,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
            array(
                'title' => "Your post is marked by lmao bruh bruh",
                'user_id' => 1,
                'object_id' => 1,
                'type' => NotificationTypeEnum::MARK_POST,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
            array(
                'title' => "Your mark is commented by bruh bruh lmao",
                'user_id' => 1,
                'object_id' => 1,
                'type' => NotificationTypeEnum::COMMENT_POST,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
        ));
    }
}
