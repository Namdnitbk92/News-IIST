<?php

use Illuminate\Database\Seeder;
use Faker\Generator as faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('123123'),
            'api_token' => str_random(60),
            'role_id' => 6,
            'belong_to_place' => 'city',
            'original_place_id' => 1,
        ]);

        DB::table('users')->insert([
            'name' => 'test',
            'email' => 'test@test.com',
            'password' => bcrypt('123123'),
            'api_token' => str_random(60),
            'role_id' => 1,
            'belong_to_place' => 'guild',
            'original_place_id' => 1,
        ]);
    }
}
