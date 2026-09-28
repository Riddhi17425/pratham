<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Usage: ->middleware('role:admin,super_admin')  or  ->middleware('role:super_admin')
 */
class RoleMiddleware
{
    private const ROLES = ['super_admin' => 1, 'admin' => 2];

    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        $allowed = array_map(fn ($r) => self::ROLES[$r] ?? 0, $roles);

        abort_unless($user->status && in_array((int) $user->role, $allowed, true), 403, 'Access denied');

        return $next($request);
    }
}
