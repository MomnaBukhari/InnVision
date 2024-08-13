<?php

// app/Http/Controllers/BookingController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function showBookingForm(Room $room)
{
    // Fetch all bookings for the room
    $bookings = Booking::where('room_id', $room->id)
        ->get()
        ->map(function ($booking) {
            return [
                'start_date' => Carbon::parse($booking->start_date)->toDateString(),
                'end_date' => Carbon::parse($booking->end_date)->toDateString(),
            ];
        });

    return view('customer.book', compact('room', 'bookings'));
}
    public function bookRoom(Request $request, Room $room)
    {
        // Validate input
        $request->validate([
            'start_date' => 'required|date',
            'duration_days' => 'required|integer|min:1',
        ]);

        $startDate = Carbon::parse($request->start_date);
        $durationDays = $request->duration_days;
        $endDate = $startDate->copy()->addDays($durationDays);

        // Check for overlapping bookings
        $conflictingBooking = Booking::where('room_id', $room->id)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                      ->orWhereBetween('end_date', [$startDate, $endDate])
                      ->orWhere(function ($query) use ($startDate, $endDate) {
                          $query->where('start_date', '<=', $startDate)
                                ->where('end_date', '>=', $endDate);
                      });
            })
            ->exists();

        if ($conflictingBooking) {
            return redirect()->back()->with('error', 'The selected dates are not available.');
        }

        // Calculate total price
        $totalPrice = $durationDays * $room->fare;

        // Create booking
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'duration_days' => $durationDays,
            'total_price' => $totalPrice,
        ]);

        // Update room status
        $room->update(['is_booked' => true]);

        return view('customer.booking-confirmation', [
            'booking' => $booking
        ]);
    }
    // public function showPendingBookings()
    // {
    //     $owner = Auth::user();

    //     if (!$owner) {
    //         return redirect()->route('login')->with('error', 'You must be logged in to view pending bookings.');
    //     }

    //     $today = Carbon::now();
    //     $startOfMonth = $today->startOfMonth()->toDateString();
    //     $endOfMonth = $today->endOfMonth()->toDateString();

    //     $pendingBookings = Booking::whereHas('room.branch.hotel', function ($query) use ($owner) {
    //         $query->where('owner_id', $owner->id);
    //     })
    //     ->whereBetween('start_date', [$startOfMonth, $endOfMonth])
    //     ->where('start_date', '>', $today)
    //     ->get();

    //     return view('owner.pending-bookings', compact('pendingBookings'));
    // }

    public function showPendingBookings()
    {
        // $currentMonth = \Illuminate\Support\Carbon::m
        $owner = Auth::user();

        // Fetch all bookings related to rooms owned by the logged-in user
        $bookings = Booking::whereHas('room.branch', function ($query) use ($owner) {
            $query->where('owner_id', $owner->id);
        })->with('room')->get();

        // Return the view with the bookings data
        return view('owner.pending-bookings', compact('bookings'));
    }


}
