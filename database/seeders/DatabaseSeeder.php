<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(PostStatusSeeder::class);
        $this->call(StatusUserSeeder::class);
        $this->call(PushNotificationSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(GenderSeeder::class);
        $this->call(RequestStatusSeeder::class);
        $this->call(RatingPostSeeder::class);
        $this->call(VersionSeeder::class);
        $this->call(MessageSeeder::class);
        $this->call(ConversationSeeder::class);
        $this->call(NotificationSeeder::class);
    }
}
