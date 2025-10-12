<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class TenantRegistrationController extends Controller
{
    public function create()
    {
        return view('auth.register-tenant');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'business_name' => ['required', 'string', 'max:255', 'unique:tenants'],
            'business_capital' => ['required', 'numeric', 'min:0'],
            'address' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'domain' => ['required', 'string', 'max:255', 'unique:domains'],
        ]);

        // Create tenant in central DB
        $tenant = Tenant::create([
            'full_name' => $request->full_name,
            'business_name' => $request->business_name,
            'business_capital' => $request->business_capital,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'status' => 'pending', // Default status
        ]);

        // Attach domain to tenant
        $tenant->domains()->create(['domain' => $request->domain . '.' . config('tenancy.central_domains')[0]]);

        // Run tenant migrations and create admin user in tenant DB
        $tenant->run(function () use ($request) {
            // Migrate tenant database
            \Artisan::call('migrate', [
                '--path' => 'database/migrations/tenant',
                '--force' => true,
            ]);

            // Create tenant Super Admin user
            $superAdminRole = Role::where('name', 'Super Admin')->first();
            User::create([
                'name' => $request->full_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $superAdminRole ? $superAdminRole->id : null,
            ]);
        });

        // Redirect to tenant's dashboard
        return redirect()->route('tenant.dashboard', ['domain' => $request->domain . '.' . config('tenancy.central_domains')[0]])
            ->with('status', 'Tenant registered successfully. Please log in.');
    }
}
