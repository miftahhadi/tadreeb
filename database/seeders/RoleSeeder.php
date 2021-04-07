<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'superadmin', 'display_as' => 'Super Admin']);
        Role::create(['name' => 'admin', 'display_as' => 'Admin']);      
        Role::create(['name' => 'teacher', 'display_as' => 'Teacher']);      
        Role::create(['name' => 'student', 'display_as' => 'Student']);      
    }
}
