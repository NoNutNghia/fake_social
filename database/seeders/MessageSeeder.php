<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('message')->insert(array(
            array(
                'sender_id' => 1,
                'conversation_id' => 1,
                'content' => "M Lmao",
                'un_read' => false,
                'created_at' => Carbon::now(),
            ),
            array(
                'sender_id' => 2,
                'conversation_id' => 1,
                'content' => "Co ma m Lmao",
                'un_read' => false,
                'created_at' => Carbon::now(),
            ),
            array(
                'sender_id' => 1,
                'conversation_id' => 1,
                'content' => "M moi Lmao",
                'un_read' => true,
                'created_at' => Carbon::now(),
            ),
            array(
                'sender_id' => 2,
                'conversation_id' => 1,
                'content' => "T k lmao, thang Duck lmao",
                'un_read' => true,
                'created_at' => Carbon::now(),
            ),
            array(
                'sender_id' => 1,
                'conversation_id' => 1,
                'content' => "U thang duck lmao",
                'un_read' => true,
                'created_at' => Carbon::now(),
            ),
        ));
    }
}
