<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\RideController;
use App\Http\Controllers\LocationController;



Route::post('/register/driver', [AuthController::class, 'registerDriver']);
Route::post('/register/customer', [AuthController::class, 'registerCustomer']);
Route::post('/login/driver', [AuthController::class, 'loginDriver']);
Route::post('/login/customer', [AuthController::class, 'loginCustomer']);


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
 
// get counties and subs 
Route::get('/counties', [LocationController::class, 'getCounties']);
Route::get('/counties/{countyName}/sub-counties', [LocationController::class, 'getSubCounties']);

// driver status
Route::patch('/drivers/{driverId}/toggle-status', [DriverController::class, 'toggleStatus']);

//get customer ride
Route::get('rides/customer/{id}', [RideController::class, 'getCustomerRides']);
//ride request 
Route::post('/rides/request', [RideController::class, 'store']);

