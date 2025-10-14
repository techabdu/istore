<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DeveloperController;
use App\Http\Controllers\TenantRegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'role:Developer'])->prefix('developer')->name('developer.')->group(function () {
    Route::get('/dashboard', [DeveloperController::class, 'index'])->name('dashboard');
    Route::get('/tenants', [DeveloperController::class, 'tenants'])->name('tenants');
    Route::get('/analytics', [DeveloperController::class, 'analytics'])->name('analytics');
});

Route::middleware('guest')->group(function () {
    Route::get('/register-tenant', [TenantRegistrationController::class, 'create'])->name('tenant.register');
    Route::post('/register-tenant', [TenantRegistrationController::class, 'store']);
});

Route::get('/dashboard', function () {
    return view('tenant.dashboard');
})->middleware(['auth', 'verified', 'role:SuperAdmin'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/central_auth.php';
