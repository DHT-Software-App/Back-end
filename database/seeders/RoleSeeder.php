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

        // profile
        $viewProfile = Bouncer::ability()->create([
            'name' => 'view:profiles',
            'title' => 'profiles'
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

        // insurance
        $viewInsurance = Bouncer::ability()->create([
            'name' => 'view:insurances',
            'title' => 'insurances'
        ]);

        $createInsurance = Bouncer::ability()->create([
            'name' => 'create:insurances',
            'title' => 'insurances'
        ]);

        $updateInsurance = Bouncer::ability()->create([
            'name' => 'update:insurances',
            'title' => 'insurances'
        ]);

        $deleteInsurance = Bouncer::ability()->create([
            'name' => 'delete:insurances',
            'title' => 'insurances'
        ]);

        // work types
        $viewWorkType = Bouncer::ability()->create([
            'name' => 'view:worktypes',
            'title' => 'worktypes'
        ]);

        $createWorkType = Bouncer::ability()->create([
            'name' => 'create:worktypes',
            'title' => 'worktypes'
        ]);

        $updateWorkType = Bouncer::ability()->create([
            'name' => 'update:worktypes',
            'title' => 'worktypes'
        ]);

        $deleteWorkType = Bouncer::ability()->create([
            'name' => 'delete:worktypes',
            'title' => 'worktypes'
        ]);

        // estimate item
        $viewEstimateItem = Bouncer::ability()->create([
            'name' => 'view:estimateitems',
            'title' => 'estimateitems'
        ]);

        $createEstimateItem = Bouncer::ability()->create([
            'name' => 'create:estimateitems',
            'title' => 'estimateitems'
        ]);

        $updateEstimateItem = Bouncer::ability()->create([
            'name' => 'update:estimateitems',
            'title' => 'estimateitems'
        ]);

        $deleteEstimateItem = Bouncer::ability()->create([
            'name' => 'delete:estimateitems',
            'title' => 'estimateitems'
        ]);

        // jobs
        $viewJobs = Bouncer::ability()->create([
            'name' => 'view:jobs',
            'title' => 'jobs'
        ]);

        $createJobs = Bouncer::ability()->create([
            'name' => 'create:jobs',
            'title' => 'jobs'
        ]);

        $updateJobs = Bouncer::ability()->create([
            'name' => 'update:jobs',
            'title' => 'jobs'
        ]);

        $deleteJobs = Bouncer::ability()->create([
            'name' => 'delete:jobs',
            'title' => 'jobs'
        ]);

        // calendars
        $viewCalendars = Bouncer::ability()->create([
            'name' => 'view:calendars',
            'title' => 'calendars'
        ]);

        $createCalendars = Bouncer::ability()->create([
            'name' => 'create:calendars',
            'title' => 'calendars'
        ]);

        $updateCalendars = Bouncer::ability()->create([
            'name' => 'update:calendars',
            'title' => 'calendars'
        ]);

        $deleteCalendars = Bouncer::ability()->create([
            'name' => 'delete:calendars',
            'title' => 'calendars'
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

        // profile
        Bouncer::allow($manager)->to($viewProfile);
        Bouncer::allow($admin)->to($viewProfile);

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

        // insurance
        Bouncer::allow($manager)->to($viewInsurance);
        Bouncer::allow($manager)->to($createInsurance);
        Bouncer::allow($manager)->to($updateInsurance);
        Bouncer::allow($manager)->to($deleteInsurance);

        Bouncer::allow($admin)->to($viewInsurance);
        Bouncer::allow($admin)->to($createInsurance);
        Bouncer::allow($admin)->to($updateInsurance);
        Bouncer::allow($admin)->to($deleteInsurance);

        // worktype
        Bouncer::allow($manager)->to($viewWorkType);
        Bouncer::allow($manager)->to($createWorkType);
        Bouncer::allow($manager)->to($updateWorkType);
        Bouncer::allow($manager)->to($deleteWorkType);

        Bouncer::allow($admin)->to($viewWorkType);
        Bouncer::allow($admin)->to($createWorkType);
        Bouncer::allow($admin)->to($updateWorkType);
        Bouncer::allow($admin)->to($deleteWorkType);

        // estimate item
        Bouncer::allow($manager)->to($viewEstimateItem);
        Bouncer::allow($manager)->to($createEstimateItem);
        Bouncer::allow($manager)->to($updateEstimateItem);
        Bouncer::allow($manager)->to($deleteEstimateItem);

        Bouncer::allow($admin)->to($viewEstimateItem);
        Bouncer::allow($admin)->to($createEstimateItem);
        Bouncer::allow($admin)->to($updateEstimateItem);
        Bouncer::allow($admin)->to($deleteEstimateItem);

        // jobs
        Bouncer::allow($manager)->to($viewJobs);
        Bouncer::allow($manager)->to($createJobs);
        Bouncer::allow($manager)->to($updateJobs);
        Bouncer::allow($manager)->to($deleteJobs);

        Bouncer::allow($admin)->to($viewJobs);
        Bouncer::allow($admin)->to($createJobs);
        Bouncer::allow($admin)->to($updateJobs);
        Bouncer::allow($admin)->to($deleteJobs);

        // calendars
        Bouncer::allow($manager)->to($viewCalendars);
        Bouncer::allow($manager)->to($createCalendars);
        Bouncer::allow($manager)->to($updateCalendars);
        Bouncer::allow($manager)->to($deleteCalendars);

        Bouncer::allow($admin)->to($viewCalendars);
        Bouncer::allow($admin)->to($createCalendars);
        Bouncer::allow($admin)->to($updateCalendars);
        Bouncer::allow($admin)->to($deleteCalendars);
    }
}
