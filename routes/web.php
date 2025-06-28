<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceNoteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;

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

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    
    // Customer Routes (Admin, Manager, Staff)
    Route::middleware(['role:admin,manager,staff'])->group(function () {
        Route::resource('customers', CustomerController::class);
    });
    
    // Vehicle Routes (Admin, Manager, Staff)
    Route::middleware(['role:admin,manager,staff'])->group(function () {
        Route::resource('vehicles', VehicleController::class);
    });
    
    // Service Routes (Admin, Manager, Staff)
    Route::middleware(['role:admin,manager,staff'])->group(function () {
        Route::resource('services', ServiceController::class);
    });
    
    // Service Notes Routes (Admin, Manager, Staff)
    Route::middleware(['role:admin,manager,staff'])->group(function () {
        Route::resource('service-notes', ServiceNoteController::class);
    });
});
