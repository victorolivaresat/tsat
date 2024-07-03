<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\SystemDataController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RolesController;
use Illuminate\Support\Facades\Route;

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

// Auth
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
});

// Logout
Route::delete('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


// Admin
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Users
    Route::get('users', [UsersController::class, 'index'])->name('users');
    Route::get('users/create', [UsersController::class, 'create'])->name('users.create');
    Route::post('users', [UsersController::class, 'store'])->name('users.store');
    Route::get('users/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [UsersController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [UsersController::class, 'destroy'])->name('users.destroy');
    Route::put('users/{user}/restore', [UsersController::class, 'restore'])->name('users.restore');
    Route::put('/users/{user}/toggle-status', [UsersController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::inertia('/users/profile', 'Users/Profile');


    // Roles
    Route::get('roles', [RolesController::class, 'index'])->name('roles');
    Route::get('roles/create', [RolesController::class, 'create'])->name('roles.create');
    Route::post('roles', [RolesController::class, 'store'])->name('roles.store');
    Route::get('roles/{role}/edit', [RolesController::class, 'edit'])->name('roles.edit');
    Route::put('roles/{role}', [RolesController::class, 'update'])->name('roles.update');
    Route::delete('roles/{role}', [RolesController::class, 'destroy'])->name('roles.destroy');

    // Notifications
    Route::get('notifications', [NotificationsController::class, 'index'])->name('notifications');
    Route::post('notifications/process-emails', [NotificationsController::class, 'processEmails'])->name('notifications.process-emails');

    // Transactions
    Route::get('transactions/system', [TransactionsController::class, 'system'])->name('transactions.system');
    Route::get('transactions/bcp', [TransactionsController::class, 'bcp'])->name('transactions.bcp');
    Route::get('transactions/ibk', [TransactionsController::class, 'ibk'])->name('transactions.ibk');
    
    // Data Load
    Route::inertia('system-data', 'Notifications/Upload');
    Route::post('system-data/upload', [SystemDataController::class, 'upload'])->name('system-data.upload');
    Route::get('system-data/transactions-per-day', [SystemDataController::class, 'transactionsPerDay'])->name('system-data.transactions-per-day');

   
});

// Images
Route::get('/img/{path}', [ImagesController::class, 'show']) ->where('path', '.*')->name('image');





