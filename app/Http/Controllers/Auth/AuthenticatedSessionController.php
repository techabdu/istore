<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Role;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();
        $user = Auth::user();

        if (tenancy()->tenant) {
            // User is in a tenant context
            if ($user->userRole->name === 'SuperAdmin') {
                return redirect()->route('tenant.dashboard');
            } elseif ($user->userRole->name === 'Admin') {
                return redirect()->route('tenant.admin.dashboard');
            }
            // Fallback for other tenant roles or unexpected scenarios
            return redirect()->route('tenant.dashboard'); // Default tenant dashboard
        } else {
            // User is in a central context
            if ($user->userRole->name === 'Developer') {
                return redirect()->route('developer.dashboard');
            } elseif ($user->userRole->name === 'SuperAdmin') { // This is for CENTRAL SuperAdmin
                return redirect()->route('dashboard'); // Central dashboard
            }
            // If a user logs in centrally and is not a Developer or Central SuperAdmin,
            // it means they are likely a tenant user trying to log in centrally.
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->withErrors(['email' => 'Tenant users must log in via their tenant domain.']);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
