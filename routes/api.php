<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', 'LoginController@login');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('vehicles', 'vehicleController');

    Route::prefix('drivers')->group(function () {
        Route::get('/', 'DriverController@index');
        Route::get('available-status', 'DriverController@statuses');
        Route::get('/get-ready-job', 'DriverController@getReadyJob')
            ->middleware('role:driver');
        Route::post('start', 'DriverController@startWork')
            ->middleware('role:driver');
    });

    Route::get('orders/statuses', 'OrderController@statuses');
    Route::get('orders', 'OrderController@index')
        ->middleware(['role:admin|driver']);
    Route::post('orders', 'OrderController@store')
        ->middleware('role:admin');
    Route::post('orders/approve', 'OrderController@approve')
        ->middleware('role:leader');

    Route::get('offices/types', 'OfficeController@types');
    Route::apiResource('offices', 'OfficeController');

    Route::group(['middleware' => ['role:leader|admin']], function () {
        Route::get('users/jobs/{userId}', 'UserController@getJobs');
    });

    Route::get('users/approvals', 'UserController@index');
});
