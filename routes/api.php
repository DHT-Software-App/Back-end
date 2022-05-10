<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RegisterController;
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
    Route::get('/{employee}', [EmployeeController::class, 'show']);
    Route::post('/', [EmployeeController::class, 'store']);
    Route::put('/{employee}', [EmployeeController::class, 'update']);
    Route::delete('/{employee}', [EmployeeController::class, 'delete']);

    // test
    Route::post(
        '/{employeee}/user', 
        [RegisterController::class, 'register']
    );
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

        Route::group([
            'prefix' => 'permissions'
        ], function($router) {
            Route::get('',[PermissionController::class, 'index']);
        });

    });
   
});