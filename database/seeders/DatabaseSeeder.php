<?php

use Illuminate\Database\Seeder;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RolesSeeder;
use Database\Seeders\UserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $permission = new PermissionSeeder();
        $permission->run();

        $roles = new RolesSeeder();
        $roles->run();

        $users = new UserSeeder();
        $users->run();
    }
}
