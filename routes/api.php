<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Mail\EmployeeMailable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;


Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('register', [AuthController::class, 'register']);

    // Route::post('/new/account', function (Request $request) {
    //     $admin = auth()->user()->employee;


    //     $email = new EmployeeMailable($admin);

    //     Mail::to('gian.carlos.perez.michel@gmail.com')->send($email);

    //     return response()->json([
    //         'message' => 'Email send successfully'
    //     ], 200);
    // });
    
  

  
});


Route::group([
    'middleware' => ['api', 'auth:api', 'can:view employees'],
    'prefix' => 'employees'

], function ($router) {

    Route::post('', [EmployeeController::class, 'create']);
});
