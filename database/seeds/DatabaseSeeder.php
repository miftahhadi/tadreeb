<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        $this->call(AdminSidebarSeeder::class);
        $this->call(RolesAndPermissionsSeeder::class);        
        $this->call(UserSeeder::class);
    }
}
