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
            'description' => 'New',
        ]);
        DB::table('status')->insert([
            'status_id' => 2,
            'description' => 'Approved',
        ]);
        DB::table('status')->insert([
            'status_id' => 3,
            'description' => 'Cancelled',
        ]);
    }
}
