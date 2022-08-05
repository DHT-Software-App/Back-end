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
        $viewAdmin = Bouncer::ability()->create([
            'name' => 'view:admin',
            'title' => 'employees'
        ]);

        $createAdmin = Bouncer::ability()->create([
            'name' => 'create:admin',
            'title' => 'employees'
        ]);

        $updateAdmin = Bouncer::ability()->create([
            'name' => 'update:admin',
            'title' => 'employees'
        ]);

        $deleteAdmin = Bouncer::ability()->create([
            'name' => 'delete:admin',
            'title' => 'employees'
        ]);

        // technician
        $viewTechnician = Bouncer::ability()->create([
            'name' => 'view:technician',
            'title' => 'employees'
        ]);

        $createTechnician = Bouncer::ability()->create([
            'name' => 'create:technician',
            'title' => 'employees'
        ]);

        $updateTechnician = Bouncer::ability()->create([
            'name' => 'update:technician',
            'title' => 'employees'
        ]);

        $deleteTechnician = Bouncer::ability()->create([
            'name' => 'delete:technician',
            'title' => 'employees'
        ]);

        // customer
        $viewCustomer = Bouncer::ability()->create([
            'name' => 'view:customers',
            'title' => 'customers'
        ]);

        $createCustomer = Bouncer::ability()->create([
            'name' => 'create:customers',
            'title' => 'customers'
        ]);

        $updateCustomer = Bouncer::ability()->create([
            'name' => 'update:customers',
            'title' => 'customers'
        ]);

        $deleteCustomer = Bouncer::ability()->create([
            'name' => 'delete:customers',
            'title' => 'customers'
        ]);

        // client
        $viewClient = Bouncer::ability()->create([
            'name' => 'view:clients',
            'title' => 'clients'
        ]);

        $createClient = Bouncer::ability()->create([
            'name' => 'create:clients',
            'title' => 'clients'
        ]);

        $updateClient = Bouncer::ability()->create([
            'name' => 'update:clients',
            'title' => 'clients'
        ]);

        $deleteClient = Bouncer::ability()->create([
            'name' => 'delete:clients',
            'title' => 'clients'
        ]);


        Bouncer::allow($manager)->to($viewAdmin);
        Bouncer::allow($manager)->to($viewEmployee);
        Bouncer::allow($manager)->to($createAdmin);
        Bouncer::allow($manager)->to($updateAdmin);
        Bouncer::allow($manager)->to($deleteAdmin);

        Bouncer::allow($admin)->to($viewTechnician);
        Bouncer::allow($admin)->to($viewEmployee);
        Bouncer::allow($admin)->to($createTechnician);
        Bouncer::allow($admin)->to($updateTechnician);
        Bouncer::allow($admin)->to($deleteTechnician);

        // customer
        Bouncer::allow($manager)->to($viewCustomer);
        Bouncer::allow($manager)->to($createCustomer);
        Bouncer::allow($manager)->to($updateCustomer);
        Bouncer::allow($manager)->to($deleteCustomer);

        Bouncer::allow($admin)->to($viewCustomer);
        Bouncer::allow($admin)->to($createCustomer);
        Bouncer::allow($admin)->to($updateCustomer);
        Bouncer::allow($admin)->to($deleteCustomer);

        // client
        Bouncer::allow($manager)->to($viewClient);
        Bouncer::allow($manager)->to($createClient);
        Bouncer::allow($manager)->to($updateClient);
        Bouncer::allow($manager)->to($deleteClient);

        Bouncer::allow($admin)->to($viewClient);
        Bouncer::allow($admin)->to($createClient);
        Bouncer::allow($admin)->to($updateClient);
        Bouncer::allow($admin)->to($deleteClient);
    }
}
