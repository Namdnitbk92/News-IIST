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
        // factory(App\Guild::class, 3)->create();
        $guilds = ['Phường Cầu Diễn', 'Phường Xuân Phương', 'Phường Phương Canh', 'Phường Mỹ Đình 1', 'Phường Mỹ Đình 2', 'Phường Tây Mỗ','Phường Mễ Trì', 'Phường Phú Đô', 'Phường Đại Mỗ', 'Phường Trung Văn'];

        foreach ($guilds as $key => $value) {
    		DB::table('guild')->insert([
	            'county_id' => 8,
	            'name' => $value,
	            'supervisor' => \App\User::where('role_id', 4)->first()->id,
	        ]);
    	}
    }
}
