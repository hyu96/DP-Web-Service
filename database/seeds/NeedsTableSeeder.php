<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NeedsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('needs')->insert([
            ['detail' => 'Chăm sóc y tế, PHCN'],
            ['detail' => 'Học văn hóa'],
            ['detail' => 'Học nghề'],
            ['detail' => 'Hỗ trợ sinh kế'],
            ['detail' => 'Phổ biến thông tin'],
            ['detail' => 'Đi lại, tiếp cận xây dựng'],
            ['detail' => 'Hỗ trợ chính sách'],
        ]);
    }
}
