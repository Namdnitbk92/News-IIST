<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role')->insert([
            'role_id' => 1,
            'description' => 'Người dân',
        ]);
        DB::table('role')->insert([
            'role_id' => 2,
            'description' => 'Người quản lý nội dung',
        ]);
        DB::table('role')->insert([
            'role_id' => 3,
            'description' => 'Người quản lý phê duyệt',
        ]);
        DB::table('role')->insert([
            'role_id' => 4,
            'description' => 'Quản lý người dùng',
        ]);
        DB::table('role')->insert([
            'role_id' => 5,
            'description' => 'Quản lý phản ánh',
        ]);
        DB::table('role')->insert([
            'role_id' => 6,
            'description' => 'Admin',
        ]);
    }
}
