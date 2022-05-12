<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// middleware we can use: 'verify.api'

Route::group([
    'middleware' => ['api'],
    'prefix' => 'auth',
], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    

    // verificar email mediante pin recibido.
    Route::post(
        'email/verify',
        [RegisterController::class, 'verifyEmail']
    );

    Route::post(
        '/reset-password', 
        [ResetPasswordController::class, 'resetPassword']
    );

    Route::post(
        '/resend/email/token', 
        [RegisterController::class, 'resendPin']
    );

    Route::post(
        '/forgot-password', 
        [ForgotPasswordController::class, 'forgotPassword']
    );

    Route::post(
        '/verify/pin', 
        [ForgotPasswordController::class, 'verifyPin']
    );

});


// employees

Route::group([
    'middleware' => ['api'],
    'prefix' => 'employees'

], function ($router) {
    Route::get('/', [EmployeeController::class, 'index']);
   
    Route::post('/', [EmployeeController::class, 'store']);
  
    Route::group(['prefix' => '{employee}'], function($router) {
        Route::get('/', [EmployeeController::class, 'show']);
        Route::put('/', [EmployeeController::class, 'update']);
        Route::delete('/', [EmployeeController::class, 'delete']);

        // test
        Route::post(
            '/user', 
            [RegisterController::class, 'register']
        );

        // role
        Route::get('/role/{role}', [RoleController::class, 'show']);
        
        // role relationship
        Route::group(['prefix' => 'relationships'], function ($router) {

            Route::group(['prefix' => 'role'], function ($router) {
                Route::post('/', [RoleController::class, 'store']);
                Route::delete('/', [RoleController::class, 'delete']);
            });
          
        });

    });

   

  
});


// users

Route::group([
    'middleware' => ['api'],
    'prefix' => 'users'
], function($router) {

    Route::get('/', [UserController::class, 'index']);

    Route::group([
       'prefix' => '{user}'
    ], function($router) {
        Route::get('',[UserController::class, 'show']);
    });
   
});