<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('post_status')->insert(array(
            array(
                'post_status' => 'public'
            ),
            array(
                'post_status' => 'friends'
            ),
            array(
                'post_status' => 'private'
            ),
            array(
                'post_status' => 'deleted'
            ),
        ));
    }
}
