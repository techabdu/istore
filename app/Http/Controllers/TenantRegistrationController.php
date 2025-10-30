<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;
use Stancl\Tenancy\Database\Models\Domain;

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
            'business_name' => ['required', 'string', 'max:255', 'unique:tenants,data->business_name'],
            'business_capital' => ['required', 'numeric', 'min:0'],
            'address' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        // Generate unique domain from business name
        $domain = Str::slug($request->business_name);
        $original_domain = $domain;
        $count = 1;
        while (Domain::where('domain', $domain . '.' . config('tenancy.central_domains')[0])->exists()) {
            $domain = $original_domain . '-' . $count;
            $count++;
        }

        // Create tenant in central DB
        $tenant = Tenant::create([
            'data' => [
                'full_name' => $request->full_name,
                'business_name' => $request->business_name,
                'business_capital' => $request->business_capital,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
                'status' => 'inactive', // Default status
            ]
        ]);

        // Attach domain to tenant
        $tenant->domains()->create(['domain' => $domain . '.salsabeelistore.shop']);

        // Create tenant Super Admin user
        $tenant->run(function () use ($request) {
            $superAdminRole = Role::where('name', 'SuperAdmin')->first();
            User::create([
                'name' => $request->full_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $superAdminRole ? $superAdminRole->id : null,
            ]);
        });

        // Redirect to tenant's login page
        return redirect('https://' . $domain . '.salsabeelistore.shop/login')
            ->with('status', 'Tenant registered successfully. Please log in.');
    }
}