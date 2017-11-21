<?php

use Illuminate\Database\Seeder;
use App\Models\SystemSetting;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0'); // disable foreign key constraints
        SystemSetting::truncate();
        DB::table('system_settings')->insert([
          [
            'name' => 'member card prefix',
            'field' => 'member_card_prefix',
            'type' => 1,
            'value' => 'T',
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s')
          ],[
            'name' => 'member card postfix',
            'field' => 'member_card_postfix',
            'type' => 1,
            'value' => 'S',
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s')
          ],[
            'name' => 'member card expired duration',
            'field' => 'member_card_due',
            'type' => 1,
            'value' => 24, //in months
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s')
          ],[
            'name' => 'member card length',
            'field' => 'member_card_length',
            'type' => 1,
            'value' => 6, 
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s')
          ]
        ]);
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1'); // enable foreign key constraints
        $this->command->info('System Setting Table Seeded');
    }
}
