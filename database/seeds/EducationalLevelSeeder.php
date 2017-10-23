<?php

use Illuminate\Database\Seeder;
use App\Models\EducationLevel;

class EducationalLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0'); // disable foreign key constraints
        EducationLevel::truncate();
        DB::table('education_levels')->insert([
          [
            'name' => 'Diploma',
            'slug' => 'diploma',
            'description' => '',
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s')
          ],[
            'name' => 'Degree',
            'slug' => 'degree',
            'description' => '',
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s')
          ]
        ]);
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1'); // enable foreign key constraints
        $this->command->info('Education Level Table Seeded');
    }
}
