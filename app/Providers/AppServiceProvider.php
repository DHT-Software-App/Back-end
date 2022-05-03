<?php

namespace App\Providers;

use App\Models\Employee;
use App\Models\EmployeeCreator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Observers\EmployeeCreatorObserver;
use App\Observers\EmployeeObserver;
use App\Observers\UserObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        // observers
       User::observe(UserObserver::class);
       Employee::observe(EmployeeObserver::class);
       EmployeeCreator::observe(EmployeeCreatorObserver::class);
    }
}
