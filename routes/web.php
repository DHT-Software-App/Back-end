<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomersController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
   // return view('auth.login');
});

//Auth::routes();

Route::group(['middleware' => ['auth']], function() {
    //Route::resource('customers', CustomersController::class);
    Route::get('home', [HomeController::class, 'index'])->name('home');

    //Datatable
    Route::get('rolesdt', [RoleController::class, 'loadDatatable'])->name('roles.loadDatatable');
    Route::get('usersdt', [UserController::class, 'loadDatatable'])->name('users.loadDatatable');
    Route::get('customersdt', [CustomersController::class, 'loadDatatable'])->name('customers.loadDatatable');

});
// Route::group(['middleware' => ['auth']], function() {
//     Route::resource('roles', RoleController::class);
//     Route::resource('users', UserController::class);
// });
