<?php

use Illuminate\Database\Seeder;

class CountyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$provinces = ['Quận Đống Đa', 'Quận Hai Bà Trưng', 'Quận Hoàng Mai', 'Quận Thanh Xuân', 'Huyện Sóc Sơn', 'Huyện Đông Anh', 'Huyện Gia Lâm', 'Quận Nam Từ Liêm', 'Huyện Thanh trì', 'Quận Bắc Từ Liêm', 'Huyện Mê Linh', 'Quận Hà Đông', 'Thị xã Sơn Tây', 'Huyện Ba Vì', 'Huyện Phúc Thọ', 'Huyện Đan Phượng' , 'Huyện Hoaì Đức', 'Huyện Quốc Oai', 'Huyện Thạch Thất', 'Huyện Chương Mỹ', 'Huyện Thanh Oai', 'Huyện Thường tín', 'Huyện Phú Xuyên', 'Huyện Ứng Hòa', 'Huyện Mỹ Đức', 'Quận Ba Đình', 'Quận Hoàn Kiếm'];
    	foreach ($provinces as $key => $value) {
    		DB::table('county')->insert([
	            'city_id' => 1,
	            'name' => $value,
	        ]);
    	}
    }
}
