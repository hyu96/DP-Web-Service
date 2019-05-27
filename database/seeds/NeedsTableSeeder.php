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
            [
                'detail' => 'Chăm sóc y tế, PHCN',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'detail' => 'Học văn hóa',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'detail' => 'Học nghề',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'detail' => 'Hỗ trợ sinh kế',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'detail' => 'Phổ biến thông tin',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'detail' => 'Đi lại, tiếp cận xây dựng',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'detail' => 'Hỗ trợ chính sách',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
