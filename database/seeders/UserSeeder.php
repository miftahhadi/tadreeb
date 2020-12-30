<?php

namespace Database\Seeders;

use App\Models\User;
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
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'username' => 'admin',
            'password' => Hash::make('1234qwer')
        ]);
        
        // Create profile
        $admin->profile()->create();

        // Assign role
        $admin->roles()->attach(2);
        
        // Issue token
        $admin->createToken('admin', ['system:basic']);

        $root = User::create([
            'name' => 'Root',
            'email' => 'root@admin.com',
            'username' => 'root',
            'password' => Hash::make('12admin12')
        ]);

        // Create profile
        $root->profile()->create();

        // Assign role
        $root->roles()->attach(1);
        
        // Issue token
        $root->createToken('admin', ['system:all']);

    }
}
