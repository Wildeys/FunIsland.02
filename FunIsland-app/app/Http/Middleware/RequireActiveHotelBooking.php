<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireActiveHotelBooking
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only apply this check to authenticated users
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Check if user has an active hotel booking
        if (!auth()->user()->hasActiveHotelBooking()) {
            return back()->with('error', 'You must have an active hotel booking before you can book additional services. Please book accommodation first.');
        }

        return $next($request);
    }
}
