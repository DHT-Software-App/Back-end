<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */ 
    public function run()
    {
        // Current roles
        $manager = Role::create(['name' => 'manager']);
        $admin = Role::create(['name' => 'admin']);
        $technician = Role::create(['name' => 'technician']);

        // Employee permissions
        Permission::create(['name' => 'show:employees'])->syncRoles([$manager, $admin]);

        Permission::create(['name' => 'create:admin'])->assignRole($manager);
        Permission::create(['name' => 'edit:admin'])->assignRole($manager);
        Permission::create(['name' => 'destroy:admin'])->assignRole($manager);

        Permission::create(['name' => 'create:technician'])->assignRole($admin);
        Permission::create(['name' => 'edit:technician'])->assignRole($admin);
        Permission::create(['name' => 'destroy:technician'])->assignRole($admin);

    }
}
