<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\RideController;
use App\Http\Controllers\LocationController;

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');


    //List of customers and driver and rides 
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/drivers', [DriverController::class, 'index'])->name('drivers.index');
    Route::get('/rides', [RideController::class, 'index'])->name('rides.index');

    // Counties 
    Route::get('/locations/counties', [LocationController::class, 'getCounties'])->name('locations.counties');
    Route::get('/locations/sub-counties/{countyName}', [LocationController::class, 'getSubCounties'])->name('locations.sub-counties');
    //status toggle
    //Route::get('/drivers/{id}/toggle-status', [DriverController::class, 'toggleStatus'])->name('drivers.toggleStatus');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Logout
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

require __DIR__.'/auth.php';