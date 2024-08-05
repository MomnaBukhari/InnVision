<?php

// app/Http/Controllers/StripeWebhookController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Webhook;
use App\Models\Booking;
use App\Models\Room;

class StripeWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $endpointSecret = config('services.stripe.webhook_secret');

        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        try {
            $event = Webhook::constructEvent(
                $payload, $sigHeader, $endpointSecret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        if ($event->type == 'checkout.session.completed') {
            $session = $event->data->object;

            $bookingId = $session->client_reference_id;

            $booking = Booking::find($bookingId);
            if ($booking) {
                $booking->status = 'confirmed';
                $booking->save();

                $room = Room::find($booking->room_id);
                if ($room) {
                    $room->is_booked = true;
                    $room->save();
                }
            }
        }

        return response()->json(['status' => 'success'], 200);
    }
}
