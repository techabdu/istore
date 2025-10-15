<?php

declare(strict_types=1);

use App\Http\Controllers\TenantTestController;
use Illuminate\Support\Facades\Route;

// Temporary route for verifying tenancy
Route::get('/verify-tenancy', [TenantTestController::class, 'verify']);

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    require __DIR__.'/auth.php';

    Route::get('/dashboard', function () {
        return view('tenant.dashboard');
    })->middleware(['auth', 'verified'])->name('tenant.dashboard');

    Route::get('/inventory', function () {
        return view('tenant.inventory.index');
    })->middleware(['auth', 'verified', 'role:Admin,Super Admin'])->name('tenant.inventory');

    Route::get('/sales', function () {
        return view('tenant.sales.index');
    })->middleware(['auth', 'verified', 'role:Admin,Super Admin'])->name('tenant.sales');

    Route::get('/finance', function () {
        return view('tenant.finance.index');
    })->middleware(['auth', 'verified', 'role:Super Admin'])->name('tenant.finance');

    Route::get('/users', function () {
        return view('tenant.users.index');
    })->middleware(['auth', 'verified', 'role:SuperAdmin'])->name('tenant.users');

    Route::get('/users/manage', function () {
        return view('tenant.users.manage');
    })->middleware(['auth', 'verified', 'role:SuperAdmin'])->name('tenant.users.manage');

    Route::get('/reports', function () {
        return view('tenant.reports.index');
    })->middleware(['auth', 'verified', 'role:Super Admin'])->name('tenant.reports');

    Route::get('/', function () {
        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    });

    Route::get('/admin/dashboard', function () {
        return view('tenant.admin.dashboard');
    })->middleware(['auth', 'verified', 'role:Admin'])->name('tenant.admin.dashboard');
});
