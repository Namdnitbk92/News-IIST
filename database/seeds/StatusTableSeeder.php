<?php

use Illuminate\Database\Seeder;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('status')->insert([
            'status_id' => 1,
            'description' => 'Mới tạo',
        ]);
        DB::table('status')->insert([
            'status_id' => 2,
            'description' => 'Đang đợi duyệt',
        ]);
        DB::table('status')->insert([
            'status_id' => 3,
            'description' => 'Đã phê duyệt',
        ]);
        DB::table('status')->insert([
            'status_id' => 4,
            'description' => 'Đã hủy ',
        ]);
    }
}
