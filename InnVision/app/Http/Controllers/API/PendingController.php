<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class PendingController extends Controller
{
    public function pendingBookingsThisMonth()
    {
        // Retrieve the user manually from the session
        $user = session('user');

        if (!$user) {
            return response()->json([
                'error' => 'User not authenticated',
                'debug' => session()->all() // Inspect session data
            ], 401);
        }

        $currentMonth = now()->month;
        $currentYear = now()->year;

        $pendingBookings = Booking::whereHas('room.branch', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->whereMonth('start_date', $currentMonth)
        ->whereYear('start_date', $currentYear)
        ->where('status', 'pending')
        ->get();

        return response()->json($pendingBookings);
    }
}
