<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DeveloperController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'role:SuperAdmin,Developer'])->prefix('developer')->name('developer.')->group(function () {
    Route::get('/dashboard', [DeveloperController::class, 'index'])->name('dashboard');
    Route::get('/tenants', [DeveloperController::class, 'tenants'])->name('tenants');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/central_auth.php';
