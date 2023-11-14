<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequestStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('request_status')->insert(array(
            array(
                'request_status' => 'user_approve'
            ),
            array(
                'request_status' => 'user_deny'
            ),
            array(
                'request_status' => 'user_pending'
            ),
        ));
    }
}
