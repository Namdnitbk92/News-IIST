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
            'description' => 'attendee',
        ]);
        DB::table('role')->insert([
            'role_id' => 2,
            'description' => 'Content manager',
        ]);
        DB::table('role')->insert([
            'role_id' => 3,
            'description' => 'Approve manager',
        ]);
        DB::table('role')->insert([
            'role_id' => 4,
            'description' => 'Users manager',
        ]);
        DB::table('role')->insert([
            'role_id' => 5,
            'description' => 'Complain manager',
        ]);
         DB::table('role')->insert([
            'role_id' => 6,
            'description' => 'Admin',
        ]);
    }
}
