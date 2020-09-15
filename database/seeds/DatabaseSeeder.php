<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{

    public function run()
    {        
        $this->call(UserSeeder::class);
        $this->call(AdminSidebarSeeder::class);
    }
}
