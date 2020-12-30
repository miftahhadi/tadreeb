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
        Role::create(['role' => 'superadmin']);
        Role::create(['role' => 'admin']);      
        Role::create(['role' => 'teacher']);      
        Role::create(['role' => 'student']);      
    }
}
