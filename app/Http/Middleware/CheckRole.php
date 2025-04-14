<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }
        
        // If no specific role is required or user is admin, allow access
        if (empty($roles) || $request->user()->isAdmin()) {
            return $next($request);
        }
        
        // Check if user has any of the required roles
        foreach ($roles as $role) {
            if ($request->user()->role === $role) {
                return $next($request);
            }
        }
        
        // If user doesn't have any of the required roles, abort with 403
        abort(403, 'Unauthorized action. This area is restricted to ' . implode(', ', $roles) . '.');
    }
}
