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
        $employee = Employee::factory()->create();

        User::create([
            'email' => 'admin@dht.com',
            'password' => bcrypt('123456'),
            'employee_id' => $employee->id
        ])->assignRole('manager');
    }
}
