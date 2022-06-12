<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
     {
         $users = [
           [
             'email'    => 'admin@admin.com',
            // 'first_name'     => 'Admin',
            // 'last_name'     => 'Admin',
             'block'     => '0',
             'lock_reason'     => '',
             'photo'     => '',
             'access_system' => '1',
             'first_use' => '1',
             'user_status' => 1,
             'user_deleted' => 0,
             'user_updated' => 0,
             'user_created' => 1,
       //      'sex' => '',
             'code_activation' => md5('admin@admin.comAdmin'),
             'password' => Hash::make('12345678'),
             'role'     => '1',
             'origin' => ''
           ]
         ];
        
        $role = new Role;
         foreach ($users as $key => $user) {
           $newUser = User::updateOrCreate([
                        'email' => $user['email']
                    ], [
                    //    'first_name' => $user['first_name'],
                    //    'last_name' => $user['last_name'],
                        'block' => $user['block'],
                        'lock_reason' => $user['lock_reason'],
                        'photo' => $user['photo'],
                   //     'sex' => $user['sex'],
                        'code_activation' => $user['code_activation'],
                        'access_system' => $user['access_system'],
                        'first_use' => $user['first_use'],
                        'user_status' => $user['user_status'],
                        'user_deleted' => $user['user_deleted'],
                        'user_updated' => $user['user_updated'],
                        'user_created' => $user['user_created'],
                        'password' => $user['password'],
                        'role' => $user['role'],
                        'origin' => $user['origin']
                    ]);

                    if ($newUser->id == 1) {
                        $role = $role->updateOrCreate(['name' => 'Admin']);
                    } else {
                        $role = $role->updateOrCreate(['name' => 'Technician']);
                    }

                   $permissions = Permission::pluck('id')->toArray();

                   $role->syncPermissions($permissions);
                   $newUser->assignRole([$role->id]);
         }
     }
}
