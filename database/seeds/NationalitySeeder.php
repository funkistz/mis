<?php

use Illuminate\Database\Seeder;
use App\Models\Nationality;

class NationalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          \DB::statement('SET FOREIGN_KEY_CHECKS = 0'); // disable foreign key constraints
          Nationality::truncate();
          DB::table('nationalities')->insert([
            [
              'name' => 'Malays',
              'slug' => 'malays',
              'description' => '',
              'is_active' => 1,
              'created_at' => date('Y-m-d H:i:s')
            ],[
              'name' => 'Indian',
              'slug' => 'indian',
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
          $this->command->info('Nationality Table Seeded');
    }
}
