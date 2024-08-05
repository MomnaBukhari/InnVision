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
        // Pass the room data to the view
        return view('customer.book', compact('room'));
    }

    public function bookRoom(Request $request, Room $room)
    {
        $request->validate([
            'start_date' => 'required|date',
            'duration_days' => 'required|integer|min:1',
        ]);

        $user = Auth::user();

        // Calculate the total price
        $totalPrice = $request->duration_days * $room->fare;

        // Create the booking
        $booking = Booking::create([
            'user_id' => $user->id,
            'room_id' => $room->id,
            'start_date' => Carbon::parse($request->start_date),
            'duration_days' => $request->duration_days,
            'total_price' => $totalPrice,
        ]);

        // Mark the room as booked
        $room->update(['is_booked' => true]);

        return view('customer.booking-confirmation', [
            'booking' => $booking
        ]);
    }


}
