<?php

use Illuminate\Database\Seeder;

class CityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('city')->insert([
            'name' => 'Thành phố Hà Nội',
            'supervisor' => \App\User::where('role_id', 6)->first()->id,
        ]);
    }
}
