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
            ['name' => 'Vận động'],
            ['name' => 'Trí tuệ'],
            ['name' => 'Thần kinh'],
            ['name' => 'Nghe nói'],
            ['name' => 'Thị giác'],
            ['name' => 'Khác'],
        ]);
    }
}
