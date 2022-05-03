<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Employee;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $employee1 = Employee::withoutEvents(function () {
            return Employee::factory()->create();
        });


        User::create([
            'email' => 'manager@dht.com',
            'password' => bcrypt('123456'),
            'employee_id' => $employee1->id,
        ])->assignRole('manager');

        
    }
}
