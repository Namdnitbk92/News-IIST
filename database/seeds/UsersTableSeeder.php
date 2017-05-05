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
        factory(App\User::class, 10)->create();

        DB::table('users')->insert([
            'name' => 'attendee',
            'email' => 'attendee@test.com',
            'password' => bcrypt('123123'),
            'api_token' => str_random(60),
            'role_id' => 1,
            'belong_to_place' => 'guild',
            'original_place_id' => 1,
        ]);

        DB::table('users')->insert([
            'name' => 'cm',
            'email' => 'cm@test.com',
            'password' => bcrypt('123123'),
            'api_token' => str_random(60),
            'role_id' => 2,
            'belong_to_place' => 'county',
            'original_place_id' => 1,
        ]);

        DB::table('users')->insert([
            'name' => 'am',
            'email' => 'am@test.com',
            'password' => bcrypt('123123'),
            'api_token' => str_random(60),
            'role_id' => 3,
            'belong_to_place' => 'guild',
            'original_place_id' => 1,
        ]);

        DB::table('users')->insert([
            'name' => 'us',
            'email' => 'us@test.com',
            'password' => bcrypt('123123'),
            'api_token' => str_random(60),
            'role_id' => 4,
            'belong_to_place' => 'guild',
            'original_place_id' => 1,
        ]);

        DB::table('users')->insert([
            'name' => 'complainmanager',
            'email' => 'complainmanager@test.com',
            'password' => bcrypt('123123'),
            'api_token' => str_random(60),
            'role_id' => 5,
            'belong_to_place' => 'county',
            'original_place_id' => 1,
        ]);

        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('123123'),
            'api_token' => str_random(60),
            'role_id' => 6,
            'belong_to_place' => 'county',
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
