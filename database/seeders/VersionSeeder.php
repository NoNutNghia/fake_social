<?php

namespace Database\Seeders;

use App\Models\Version;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class VersionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Version::insert(array(
            array(
                'version' => '1.0.1.1',
                'created_at' => Carbon::now(),
            ),
            array(
                'version' => '1.0.1.2',
                'created_at' => Carbon::now(),
            ),
            array(
                'version' => '1.0.1.3',
                'created_at' => Carbon::now(),
            ),
            array(
                'version' => '1.0.1.3a',
                'created_at' => Carbon::now(),
            ),
            array(
                'version' => '1.0.1.3b',
                'created_at' => Carbon::now(),
            ),
            array(
                'version' => '1.0.1.4',
                'created_at' => Carbon::now(),
            ),
            array(
                'version' => '1.0.2',
                'created_at' => Carbon::now(),
            ),
        ));
    }
}
