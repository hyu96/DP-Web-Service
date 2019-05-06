<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Disability;
use App\Models\UserDisability;
use App\Models\Need;
use App\Models\Role;
use App\Models\UserNeed;
use App\Models\District;
use App\Models\Subdistrict;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Do Quang Huy',
                'email' => 'huydq@gmail.com',
                'phone' => '0368636007',
                'identity_card' => '745632178',
                'gender' => 'male',
                'birthday' => '1996-10-25',
                'address' => 'So 36, ngo 54 Phuc Tan, Hoan Kiem, Ha Noi',
                'disability_id' => 2,
                'disability_detail' => 'Binh thuong',
                'district_id' => 2,
                'subdistrict_id' => 37,
                'academic_level' => '10/12',
                'specialize' => 'CNTT',
                'labor_ability' => true,
                'employment_status' => 'IT',
                'income' => 9500000,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        UserNeed::insert([
            [
                'user_id' => 1,
                'need_id' => 1,
                'detail' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 1,
                'need_id' => 3,
                'detail' => 'Project Manager',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
