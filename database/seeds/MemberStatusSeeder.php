<?php

use Illuminate\Database\Seeder;
use App\Models\MemberStatus;

class MemberStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0'); // disable foreign key constraints
        MemberStatus::truncate();
        DB::table('member_statuses')->insert([
          [
            'name' => 'pending',
            'slug' => 'pending',
            'description' => '',
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s')
          ],[
            'name' => 'approved',
            'slug' => 'approved',
            'description' => '',
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s')
          ],[
            'name' => 'rejected',
            'slug' => 'rejected',
            'description' => '',
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s')
          ]
        ]);
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1'); // enable foreign key constraints
        $this->command->info('Member Status Table Seeded');
    }
}
