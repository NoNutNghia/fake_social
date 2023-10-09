<?php

namespace Database\Seeders;

use App\Enum\GenderEnum;
use App\Enum\RoleEnum;
use App\Enum\StatusUserEnum;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => "NoNutNghia",
            'avatar' => '',
            'email' => 'trustmebro@fakenew.com',
            'uuid' => Str::uuid(),
            'email_verified_at' => Carbon::now(),
            'coins' => 69,
            'status_user' => StatusUserEnum::ACTIVE,
            'role' => RoleEnum::USER,
            'gender' => GenderEnum::MALE,
            'phone' => '0969696969',
            'password' => sha1('password')
        ]);
    }
}
