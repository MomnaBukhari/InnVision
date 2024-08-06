<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function createCheckoutSession(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Room Booking',
                    ],
                    'unit_amount' => $request->total_price * 100, // amount in cents
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('payment.success', ['booking_id' => $request->booking_id]),
            'cancel_url' => route('payment.cancel'),
            'client_reference_id' => $request->booking_id,
        ]);

        return response()->json(['id' => $session->id]);
    }

    public function paymentSuccess($booking_id)
    {
        // Find the booking by its ID
        $booking = Booking::findOrFail($booking_id);

        // Find the associated room
        $room = Room::findOrFail($booking->room_id);

        // Check if the room is already booked
        if (!$room->is_booked) {
            $room->update(['is_booked' => true]);
        }

        // Get the user who made the booking
        $user = Auth::user();

        // Pass booking, room, and user data to the view
        return view('customer.payment-success', [
            'booking' => $booking,
            'room' => $room,
            'user' => $user,
        ]);
    }
    public function paymentCancel()
    {
        return view('customer.payment-cancel');
    }
}
