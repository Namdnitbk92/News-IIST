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
            'description' => 'normal',
        ]);
        DB::table('role')->insert([
            'role_id' => 2,
            'description' => 'role for create news',
        ]);
        DB::table('role')->insert([
            'role_id' => 3,
            'description' => 'role approve news',
        ]);
        DB::table('role')->insert([
            'role_id' => 4,
            'description' => 'role for users management',
        ]);
        DB::table('role')->insert([
            'role_id' => 5,
            'description' => 'role for reflect processer ',
        ]);
         DB::table('role')->insert([
            'role_id' => 6,
            'description' => 'admin',
        ]);
    }
}
