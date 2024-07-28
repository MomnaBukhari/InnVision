<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckApproval
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        // Define an array of routes that should bypass the approval check
        $excludedRoutes = [
            'owner.dashboard',
            'customer.dashboard',
            'admin.dashboard',
        ];

        // Check if the current route name is in the excluded routes list
        if ($user && $user->role === 'hotel_owner' && !$user->is_approved && !in_array($request->route()->getName(), $excludedRoutes)) {
            return redirect()->route('pending-approval'); // Redirect to pending approval page
        }

        return $next($request);
    }
}
