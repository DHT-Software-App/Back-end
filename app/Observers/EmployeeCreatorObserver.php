<?php

namespace App\Observers;

use App\Models\Employee;
use App\Models\EmployeeCreator;

class EmployeeCreatorObserver
{
    /**
     * Handle the EmployeeCreator "created" event.
     *
     * @param  \App\Models\EmployeeCreator  $employeeCreator
     * @return void
     */
    public function created(EmployeeCreator $employeeCreator)
    {
        //
    }

    /**
     * Handle the EmployeeCreator "updated" event.
     *
     * @param  \App\Models\EmployeeCreator  $employeeCreator
     * @return void
     */
    public function updated(EmployeeCreator $employeeCreator)
    {
        //
    }

    /**
     * Handle the EmployeeCreator "deleted" event.
     *
     * @param  \App\Models\EmployeeCreator  $employeeCreator
     * @return void
     */
    public function deleted(EmployeeCreator $employeeCreator)
    {
        Employee::destroy($employeeCreator->employee_id);
    }

    /**
     * Handle the EmployeeCreator "restored" event.
     *
     * @param  \App\Models\EmployeeCreator  $employeeCreator
     * @return void
     */
    public function restored(EmployeeCreator $employeeCreator)
    {
        //
    }

    /**
     * Handle the EmployeeCreator "force deleted" event.
     *
     * @param  \App\Models\EmployeeCreator  $employeeCreator
     * @return void
     */
    public function forceDeleted(EmployeeCreator $employeeCreator)
    {
        //
    }
}
