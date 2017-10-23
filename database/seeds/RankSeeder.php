<?php

use Illuminate\Database\Seeder;
use App\Models\Rank;

class RankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0'); // disable foreign key constraints
        Rank::truncate();
        DB::table('ranks')->insert([
          [
            'name' => 'Prebet',
            'slug' => 'prebet',
            'description' => '',
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s')
          ],[
            'name' => 'Lans. Koperal',
            'slug' => 'lans_koperal',
            'description' => '',
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s')
          ],[
            'name' => 'Koperal',
            'slug' => 'koperal',
            'description' => '',
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s')
          ],[
            'name' => 'Sarjan',
            'slug' => 'sarjan',
            'description' => '',
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s')
          ],[
            'name' => 'Sarjan Muda',
            'slug' => 'sarjan_muda',
            'description' => '',
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s')
          ],[
            'name' => 'Sarjan Kanan',
            'slug' => 'sarjan_kanan',
            'description' => '',
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s')
          ],[
            'name' => 'Sarjan Tinggi',
            'slug' => 'sarjan_tinggi',
            'description' => '',
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s')
          ],[
            'name' => 'Leftenan Muda',
            'slug' => 'leftenan_muda',
            'description' => '',
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s')
          ]
        ]);
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1'); // enable foreign key constraints
        $this->command->info('Rank Table Seeded');
    }
}
