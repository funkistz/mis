<?php

use App\User;
use Illuminate\Database\Seeder;
use jeremykenedy\LaravelRoles\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0'); // disable foreign key constraints
        Role::truncate();
        /*
         * Add Roles
         *
         */
        if (Role::where('slug', '=', 'admin')->first() === null) {
            $adminRole = Role::create([
                'name'        => 'Admin',
                'slug'        => 'admin',
                'description' => 'Admin Role',
                'level'       => 5,
            ]);
        }

        if (Role::where('slug', '=', 'user')->first() === null) {
            $userRole = Role::create([
                'name'        => 'User',
                'slug'        => 'user',
                'description' => 'User Role',
                'level'       => 1,
            ]);
        }

        if (Role::where('slug', '=', 'staff')->first() === null) {
            $userRole = Role::create([
                'name'        => 'Staff',
                'slug'        => 'staff',
                'description' => 'Staff Role',
                'level'       => 4,
            ]);
        }

        if (Role::where('slug', '=', 'officer')->first() === null) {
            $userRole = Role::create([
                'name'        => 'Officer',
                'slug'        => 'officer',
                'description' => 'Officer Role',
                'level'       => 3,
            ]);
        }

        if (Role::where('slug', '=', 'co_officer')->first() === null) {
            $userRole = Role::create([
                'name'        => 'Co-Curriculumn Officer',
                'slug'        => 'co_officer',
                'description' => 'Co-Curriculumn Officer Role',
                'level'       => 2,
            ]);
        }

        if (Role::where('slug', '=', 'member')->first() === null) {
            $userRole = Role::create([
                'name'        => 'Member',
                'slug'        => 'member',
                'description' => 'Member Role',
                'level'       => 1,
            ]);
        }

        if (Role::where('slug', '=', 'coach')->first() === null) {
            $userRole = Role::create([
                'name'        => 'Coach',
                'slug'        => 'coach',
                'description' => 'Coach Role',
                'level'       => 1,
            ]);
        }

        \DB::statement('SET FOREIGN_KEY_CHECKS = 1'); // enable foreign key constraints
    }
}
