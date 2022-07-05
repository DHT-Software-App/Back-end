<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\CustomersController;
use App\Http\Controllers\API\CityController;
use App\Http\Controllers\API\StateController;
use App\Http\Controllers\API\JobStatusController;
use App\Http\Controllers\API\TypeWorkController;
use App\Http\Controllers\API\JobsController;
use App\Http\Controllers\API\InsuredCompanyController;
use App\Http\Controllers\API\EmployeeController;
use App\Http\Controllers\API\ClientsController;
use App\Http\Controllers\FunctionsController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\RolesController;
use App\Http\Controllers\API\PermissionController;
//use App\Http\Controllers\MailerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('register',[RegisterController::class,'register']);
Route::post('login',[RegisterController::class,'login']);

Route::group(['middleware' => ['auth:api']], function () {
Route::post('logout', [RegisterController::class, 'logout']);
});

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

    Route::group(['middleware' => ['auth:api']], function() {
   
    Route::resource('cities', CityController::class);
    Route::resource('states', StateController::class);
    Route::resource('typejobs', JobStatusController::class);
    Route::resource('typeworks', TypeWorkController::class);
    Route::resource('jobs', JobsController::class);
    Route::resource('insuredcompanies', InsuredCompanyController::class);
    Route::resource('employees', EmployeeController::class);
    Route::resource('clients',ClientsController::class);
    Route::resource('calendars', CalendarController::class);
    Route::resource('users', UserController::class);
    Route::resource('roles', RolesController::class);
    Route::resource('permissions', PermissionController::class);

    Route::get('permissions/roles/{id}',[PermissionController::class ,'rolesPermission']);
    
    Route::post('roles/assing',[RolesController::class,'assingRoles']);


    Route::get('customers/detailscontact/{id_customer}',[CustomersController::class,'rolesPermission']);
    Route::get('customers/detailsinsured/{id_customer}',[CustomersController::class,'detailsCustomerInsured']);

    Route::get('employees/detailscontact/{id_employee}',[EmployeeController::class,'detailsEmployeesContact']);

    //Route::resource('account/activate/{$id}',[FunctionsController::class,'activate']);

    // Route::post('/customers',[CustomersController::class,'store']);
    // Route::put('/customers/{id}',[CustomersController::class,'update']);
    // Route::delete('/customers/{id}',[CustomersController::class,'delete']);
    // Route::post('/logout',[CustomersController::class,'logout']);

     Route::group(['middleware' => ['role:admin']], function () {
        Route::resource('customers', CustomersController::class);
     });

});


Route::get('account/activate/{id}',[RegisterController::class,'activateUser']);

