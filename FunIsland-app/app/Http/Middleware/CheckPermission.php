<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = $request->user();
        if (!$user) {
            abort(403, 'Unauthorized access.');
        }

        // Check if user has the specified permission
        if (!method_exists($user, $permission) || !$user->$permission()) {
            abort(403, "Unauthorized access. Required permission: {$permission}");
        }

        return $next($request);
    }
} 