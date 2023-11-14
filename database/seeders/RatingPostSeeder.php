<?php

namespace Database\Seeders;

use App\Enum\RatingPostEnum;
use App\Models\RatingPost;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RatingPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RatingPost::insert(array(
            array(
                "user_id" => 2,
                "post_id" => 1,
                "rating" => RatingPostEnum::KUDOS,
                "created_at" => Carbon::now(),
            ),
            array(
                "user_id" => 4,
                "post_id" => 1,
                "rating" => RatingPostEnum::DISAPPOINTED,
                "created_at" => Carbon::now(),
            ),
        ));
    }
}
