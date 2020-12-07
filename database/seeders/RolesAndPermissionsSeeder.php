<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions array
        $arrayOfTeacherPermissions = ['create lesson','edit lesson','update lesson','delete lesson', 
            'create exam', 'edit exam', 'update exam', 'delete exam', 'view exam',
            'create question', 'edit question', 'update question', 'delete question',
            'create classroom','delete classroom',
            'show exam result'
        ];

        $arrayOfAdminPermissions = ['create group','edit group','update group','delete group',
            'edit classroom','update classroom',
            'create user','edit user','update user','delete user','assign user to classroom','assign user to exam',
            'access admin'
        ];

        $arrayOfSuperadminPermissions = ['read setting','update setting'];

        // Input permissions
        $teacherPermissions = collect($arrayOfTeacherPermissions)->map(function ($permission) {
            return ['name' => $permission, 'guard_name' => 'web'];
        });

        Permission::insert($teacherPermissions->toArray());

        $adminPermissions = collect($arrayOfAdminPermissions)->map(function ($permission) {
            return ['name' => $permission, 'guard_name' => 'web'];
        });

        Permission::insert($adminPermissions->toArray());

        $superadminPermissions = collect($arrayOfSuperadminPermissions)->map(function ($permission) {
            return ['name' => $permission, 'guard_name' => 'web'];
        });

        Permission::insert($superadminPermissions->toArray());

        // create roles
        $superadmin = Role::create(['name' => 'Superadmin'])->givePermissionTo(Permission::all());

        $admin = Role::create(['name' => 'Admin']);
        $admin->givePermissionTo($arrayOfTeacherPermissions);
        $admin->givePermissionTo($arrayOfAdminPermissions);

        $teacher = Role::create(['name' => 'Teacher'])->givePermissionTo($arrayOfTeacherPermissions);

        $student = Role::create(['name' => 'Student']);
        
    }
}
