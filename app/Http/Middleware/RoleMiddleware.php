<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        $user = $request->user();
        $userRoleName = $user->userRole->name ?? null;
        $isCentralUser = ($user->tenant_id === null); // Determine if the user is a central user

        // Check if the user has the required role for the current route
        if (! $userRoleName || ! in_array($userRoleName, $roles)) {
            abort(403, 'Unauthorized action for this role.');
        }

        // Now, check for cross-context access
        if (tenancy()->tenant) {
            // Request is in a tenant context
            if ($isCentralUser) {
                // A central user is trying to access a tenant resource
                abort(403, 'Central users cannot access tenant resources.');
            }
        } else {
            // Request is in a central context
            if (! $isCentralUser) {
                // A tenant user is trying to access a central resource
                abort(403, 'Tenant users cannot access central resources.');
            }
        }

        return $next($request);
    }
}
