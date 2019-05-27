<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DisabilitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('disabilities')->insert([
            [
                'name' => 'Vận động',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Trí tuệ',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Thần kinh',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Nghe nói',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Thị giác',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Khác',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
