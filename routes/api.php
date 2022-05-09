<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

// middleware we can use: 'verify.api'

Route::group([
    'middleware' => ['api'],
    'prefix' => 'auth',
], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);

    Route::group(['prefix' => 'me'], function() {
        Route::get('', [AuthController::class, 'me']);
    });

    Route::group([
        'middleware' => ['auth:api', 'can:view employees'],
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
            [App\Http\Controllers\RegisterController::class, 'register']
        );
    });
    

    // verificar email mediante pin recibido.
    Route::post(
        'email/verify',
        [App\Http\Controllers\RegisterController::class, 'verifyEmail']
    );

    Route::post(
        '/reset-password', 
        [App\Http\Controllers\ResetPasswordController::class, 'resetPassword']
    );

    Route::post(
        '/resend/email/token', 
        [App\Http\Controllers\RegisterController::class, 'resendPin']
    );

    Route::post(
        '/forgot-password', 
        [App\Http\Controllers\ForgotPasswordController::class, 'forgotPassword']
    );

    Route::post(
        '/verify/pin', 
        [App\Http\Controllers\ForgotPasswordController::class, 'verifyPin']
    );

});




