<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConversationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('conversation')->insert(array(
            array(
                'user_id' => 1,
                'partner_id' => 2,
                'created_at' => Carbon::now()
            )
        ));
    }
}
