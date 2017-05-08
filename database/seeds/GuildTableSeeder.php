<?php

use Illuminate\Database\Seeder;

class GuildTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $guilds = ['Phường Cầu Diễn', 'Phường Xuân Phương', 'Phường Phương Canh', 'Phường Mỹ Đình 1', 'Phường Mỹ Đình 2', 'Phường Tây Mỗ','Phường Mễ Trì', 'Phường Phú Đô', 'Phường Đại Mỗ', 'Phường Trung Văn'];
        $guildBD = [ 'Phường Phúc Xá', 'Phường Trúc Bạch', 'Phường Vĩnh Phúc', 'Phường Cống Vị', 'Phường Liễu Giai', 'Phường Nguyễn Trung Trực', 'Phường Quán Thánh', 'Phường Ngọc Hà', 'Phường Điện Biên', 'Phường Đội Cấn', 'Phường Ngọc Khánh', 'Phường Kim Mã', 'Phường Giảng Võ'];
        $guildHK = [ 'Phường Phúc Tân', 'Phường Đồng Xuân', 'Phường Hàng Mã', 'Phường Hàng Buồm', 'Phường Hàng Đào', 'Phường Hàng Bồ', 'Phường Cửa Đông', 'Phường Lý Thái Tổ', 'Phường Hàng Bạc', 'Phường Hàng Gai', 'Phường Chương Dương Độ', 'Phường Hàng Trống', 'Phường Cửa Nam', 'Phường Hàng Bông', 'Phường Tràng Tiền', 'Phường Trần Hưng Đạo', 'Phường Phan Chu Trinh', 'Phường Hàng Bài'];

        foreach ($guilds as $key => $value) {
    		DB::table('guild')->insert([
	            'county_id' => 8,
	            'name' => $value,
	        ]);
    	}

        foreach ($guildBD as $key => $value) {
            DB::table('guild')->insert([
                'county_id' => 26,
                'name' => $value,
            ]);
        }

         foreach ($guildHK as $key => $value) {
            DB::table('guild')->insert([
                'county_id' => 27,
                'name' => $value,
            ]);
        }
    }
}
