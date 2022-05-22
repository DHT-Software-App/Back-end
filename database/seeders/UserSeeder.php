<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $employee = Employee::withoutEvents(function () {
            return Employee::factory()->create();
        });

        $employee->assign('manager');

        User::create([
            'email' => 'manager@dht.com',
            'password' => bcrypt('123456'),
            'email_verified_at' => Carbon::now()->getTimestamp(),
            'employee_id' => $employee->id
        ]);

        
    }
}
