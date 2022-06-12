<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'customers-list',
            'customers-create',
            'customers-edit',
            'customers-delete',
            'employee-list',
            'employee-create',
            'employee-edit',
            'employee-delete'
        ];

      foreach ($permissions as $permission) {
           Permission::create(['name' => $permission]);
      }
    }
}
