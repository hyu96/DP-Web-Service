<?php

use Illuminate\Database\Seeder;

class DistrictsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('districts')->insert([
            ['id' => 1, 'name' => 'Quận Ba Đình', 'type' => 'Quận'],
            ['id' => 2, 'name' => 'Quận Hoàn Kiếm', 'type' => 'Quận'],
            ['id' => 3, 'name' => 'Quận Tây Hồ', 'type' => 'Quận'],
            ['id' => 4, 'name' => 'Quận Long Biên', 'type' => 'Quận'],
            ['id' => 5, 'name' => 'Quận Cầu Giấy', 'type' => 'Quận'],
            ['id' => 6, 'name' => 'Quận Đống Đa', 'type' => 'Quận'],
            ['id' => 7, 'name' => 'Quận Hai Bà Trưng', 'type' => 'Quận'],
            ['id' => 8, 'name' => 'Quận Hoàng Mai', 'type' => 'Quận'],
            ['id' => 9, 'name' => 'Quận Thanh Xuân', 'type' => 'Quận'],
            ['id' => 16, 'name' => 'Huyện Sóc Sơn',  'type' =>'Huyện'],
            ['id' => 17, 'name' => 'Huyện Đông Anh',  'type' =>'Huyện'],
            ['id' => 18, 'name' => 'Huyện Gia Lâm',  'type' =>'Huyện'],
            ['id' => 19, 'name' => 'Quận Nam Từ Liêm', 'type' => 'Quận'],
            ['id' => 20, 'name' => 'Huyện Thanh Trì',  'type' =>'Huyện'],
            ['id' => 21, 'name' => 'Quận Bắc Từ Liêm', 'type' => 'Quận'],
            ['id' => 250, 'name' => 'Huyện Mê Linh',  'type' => 'Huyện'],
            ['id' => 268, 'name' => 'Quận Hà Đông', 'type' =>  'Quận'],
            ['id' => 269, 'name' => 'Thị xã Sơn Tây', 'type' => 'Thị xã'],
            ['id' => 271, 'name' => 'Huyện Ba Vì',  'type' => 'Huyện'],
            ['id' => 272, 'name' => 'Huyện Phúc Thọ',  'type' => 'Huyện'],
            ['id' => 273, 'name' => 'Huyện Đan Phượng',  'type' => 'Huyện'],
            ['id' => 274, 'name' => 'Huyện Hoài Đức',  'type' => 'Huyện'],
            ['id' => 275, 'name' => 'Huyện Quốc Oai',  'type' => 'Huyện'],
            ['id' => 276, 'name' => 'Huyện Thạch Thất',  'type' => 'Huyện'],
            ['id' => 277, 'name' => 'Huyện Chương Mỹ',  'type' => 'Huyện'],
            ['id' => 278, 'name' => 'Huyện Thanh Oai',  'type' => 'Huyện'],
            ['id' => 279, 'name' => 'Huyện Thường Tín',  'type' => 'Huyện'],
            ['id' => 280, 'name' => 'Huyện Phú Xuyên',  'type' => 'Huyện'],
            ['id' => 281, 'name' => 'Huyện Ứng Hòa',  'type' => 'Huyện'],
            ['id' => 282, 'name' => 'Huyện Mỹ Đức', 'type' =>  'Huyện']
        ]);
    }
}
