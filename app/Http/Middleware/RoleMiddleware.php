<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Example usage: middleware('role:admin') or middleware('role:admin,staff')
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        // If no roles specified, just pass through
        if (empty($roles)) {
            return $next($request);
        }

        // Match simple role string on users.role column
        $userRole = (string) ($user->role ?? '');
        foreach ($roles as $role) {
            if ($userRole === $role) {
                return $next($request);
            }
        }

        abort(403, 'Anda tidak memiliki akses untuk halaman ini.');
    }
}
