<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'nama' => 'Admin',
            'email' => 'admin@admin.com',
            'username' => 'admin',
            'password' => Hash::make('1234qwer')
        ]);

        $admin->assignRole('admin');

        $root = User::create([
            'nama' => 'Root',
            'email' => 'root@admin.com',
            'username' => 'root',
            'password' => Hash::make('_kalam*haqiqi_')
        ]);

        $root->assignRole('superadmin');
    }
}
