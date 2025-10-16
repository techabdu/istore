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
        $request->authenticate('tenant_web'); // Use the tenant_web guard
        $request->session()->regenerate();
        $user = Auth::guard('tenant_web')->user(); // Get user from tenant_web guard

        if ($user->userRole->name === 'SuperAdmin') {
            return redirect()->route('tenant.dashboard');
        } elseif ($user->userRole->name === 'Admin') {
            return redirect()->route('tenant.admin.dashboard');
        }
        // Fallback for other tenant roles or unexpected scenarios
        return redirect()->route('tenant.dashboard'); // Default tenant dashboard
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('tenant_web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
