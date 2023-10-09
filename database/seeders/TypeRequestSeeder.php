<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('type_request')->insert(array(
            array(
                'type_request_name' => 'user_receive'
            ),
            array(
                'type_request_name' => 'user_send'
            )
        ));
    }
}
