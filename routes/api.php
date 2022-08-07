<?php

use App\Http\Controllers\AbilityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EstimateItemController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkTypeController;
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
        [RegisterController::class, 'verifyPin']
    );
});


// employees

Route::group([
    'middleware' => ['api'],
    'prefix' => 'employees'

], function ($router) {
    Route::get('/', [EmployeeController::class, 'index']);

    Route::post('/', [EmployeeController::class, 'store']);

    Route::group(['prefix' => '{employee}'], function ($router) {

        Route::get('/', [EmployeeController::class, 'show']);
        Route::put('/', [EmployeeController::class, 'update']);
        Route::delete('/', [EmployeeController::class, 'delete']);

        Route::group(['prefix' => 'user'], function ($router) {

            Route::post(
                '/',
                [RegisterController::class, 'register']
            );

            Route::group(['prefix' => '{user}'], function ($router) {
                Route::get('/', [UserController::class, 'show']);
            });
        });


        // role
        Route::get('/role/{role}', [RoleController::class, 'show']);

        // role relationship
        Route::group(['prefix' => 'relationships'], function ($router) {

            Route::group(['prefix' => 'role'], function ($router) {
                Route::post('/', [RoleController::class, 'store']);
            });
        });

        // abilities
        Route::group(['prefix' => 'abilities'], function () {

            Route::get('/', [AbilityController::class, 'index']);

            Route::get('/{ability}', [AbilityController::class, 'show']);
        });
    });
});


// users

Route::group([
    'middleware' => ['api'],
    'prefix' => 'users'
], function ($router) {

    Route::get('/', [UserController::class, 'index']);

    Route::group([
        'prefix' => '{user}'
    ], function ($router) {
        Route::get('', [UserController::class, 'show']);


        Route::group(['prefix' => 'profile/{profile}'], function ($router) {
            Route::get('', [ProfileController::class, 'show']);
            // Route::put('', [ProfileController::class, 'update']);
        });
    });
});


// clients

Route::group([
    'middleware' => ['api'],
    'prefix' => 'clients'

], function ($router) {
    Route::get('/', [ClientController::class, 'index']);

    Route::post('/', [ClientController::class, 'store']);

    Route::group(['prefix' => '{client}'], function ($router) {

        Route::get('/', [ClientController::class, 'show']);
        Route::put('/', [ClientController::class, 'update']);
        Route::delete('/', [ClientController::class, 'delete']);
    });
});


// customers
Route::group([
    'middleware' => ['api'],
    'prefix' => 'customers'

], function ($router) {
    Route::get('/', [CustomerController::class, 'index']);

    Route::post('/', [CustomerController::class, 'store']);

    Route::group(['prefix' => '{customer}'], function ($router) {

        Route::get('/', [CustomerController::class, 'show']);
        Route::put('/', [CustomerController::class, 'update']);
        Route::delete('/', [CustomerController::class, 'delete']);
    });
});

// insurances
Route::group([
    'middleware' => ['api'],
    'prefix' => 'insurances'

], function ($router) {
    Route::get('/', [InsuranceController::class, 'index']);

    Route::post('/', [InsuranceController::class, 'store']);

    Route::group(['prefix' => '{insurance}'], function ($router) {

        Route::get('/', [InsuranceController::class, 'show']);
        Route::put('/', [InsuranceController::class, 'update']);
        Route::delete('/', [InsuranceController::class, 'delete']);
    });
});

// work types
Route::group([
    'middleware' => ['api'],
    'prefix' => 'work_types'

], function ($router) {
    Route::get('/', [WorkTypeController::class, 'index']);

    Route::post('/', [WorkTypeController::class, 'store']);

    Route::group(['prefix' => '{workType}'], function ($router) {

        Route::get('/', [WorkTypeController::class, 'show']);
        Route::put('/', [WorkTypeController::class, 'update']);
        Route::delete('/', [WorkTypeController::class, 'delete']);
    });
});

// estimate items
Route::group([
    'middleware' => ['api'],
    'prefix' => 'estimate_items'

], function ($router) {
    Route::get('/', [EstimateItemController::class, 'index']);

    Route::post('/', [EstimateItemController::class, 'store']);

    Route::group(['prefix' => '{estimateItem}'], function ($router) {

        Route::get('/', [EstimateItemController::class, 'show']);
        Route::put('/', [EstimateItemController::class, 'update']);
        Route::delete('/', [EstimateItemController::class, 'delete']);
    });
});
