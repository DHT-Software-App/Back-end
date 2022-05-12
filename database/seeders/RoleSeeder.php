<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Silber\Bouncer\BouncerFacade as Bouncer;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */ 
    public function run()
    {
        // Roles

        $manager = Bouncer::role()->create([
            'name' => 'manager',
            'title' => 'Manager',
        ]);

        $admin = Bouncer::role()->create([
            'name' => 'admin',
            'title' => 'Administrator',
        ]);

        $technician = Bouncer::role()->create([
            'name' => 'technician',
            'title' => 'Technician',
        ]);

        // Abilities

        $viewEmployee = Bouncer::ability()->create([
            'name' => 'view:employees',
            'title' => 'employees'
        ]);

        // admin
        $createAdmin = Bouncer::ability()->create([
            'name' => 'create:admin',
            'title' => 'employees'
        ]);

        $editAdmin = Bouncer::ability()->create([
            'name' => 'edit:admin',
            'title' => 'employees'
        ]);

        $deleteAdmin = Bouncer::ability()->create([
            'name' => 'delete:admin',
            'title' => 'employees'
        ]);

         // technician
         $createTechnician = Bouncer::ability()->create([
            'name' => 'create:technician',
            'title' => 'employees'
        ]);

        $editTechnician = Bouncer::ability()->create([
            'name' => 'edit:technician',
            'title' => 'employees'
        ]);

        $deleteTechnician = Bouncer::ability()->create([
            'name' => 'delete:technician',
            'title' => 'employees'
        ]);


        Bouncer::allow($manager)->to($viewEmployee);
        Bouncer::allow($manager)->to($createAdmin);
        Bouncer::allow($manager)->to($editAdmin);
        Bouncer::allow($manager)->to($deleteAdmin);

        Bouncer::allow($admin)->to($viewEmployee);
        Bouncer::allow($admin)->to($createTechnician);
        Bouncer::allow($admin)->to($editTechnician);
        Bouncer::allow($admin)->to($deleteTechnician);

    }
}
