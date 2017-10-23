<?php

use Illuminate\Database\Seeder;
use App\Models\Race;

class RaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0'); // disable foreign key constraints
        Race::truncate();
        DB::table('races')->insert([
          [
            'name' => 'Malay',
            'slug' => 'malay',
            'description' => '',
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s')
          ],[
            'name' => 'India',
            'slug' => 'india',
            'description' => '',
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s')
          ],[
            'name' => 'Chinese',
            'slug' => 'chinese',
            'description' => '',
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s')
          ]
        ]);
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1'); // enable foreign key constraints
        $this->command->info('Race Table Seeded');
    }
}
