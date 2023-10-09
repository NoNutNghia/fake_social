<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status_user')->insert(array(
            array(
                'status_name' => 'active'
            ),
            array(
                'status_name' => 'in_active'
            ),
            array(
                'status_name' => 'disable'
            )
        ));
    }
}
