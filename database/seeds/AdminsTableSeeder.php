<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Support\Str;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            [
                'name' => 'AdminCity',
                'email' => 'admin_city@gmail.com',
                'phone' => '0123456789',
                'role' => 0,
                'identity_card' => '978456321',
                'password' => Hash::make('123456789'),
                'reset_password' => 1,
                'gender' => 'male',
                'birthday' => '1996-10-25',
                'district_id' => null,
                'api_token' => Str::random(60),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'AdminDistrict',
                'email' => 'admin_district@gmail.com',
                'phone' => '0123456789',
                'role' => 1,
                'identity_card' => '456817293',
                'password' => Hash::make('123456789'),
                'reset_password' => 1,
                'gender' => 'male',
                'birthday' => '1996-10-25',
                'district_id' => 2,
                'api_token' => Str::random(60),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
