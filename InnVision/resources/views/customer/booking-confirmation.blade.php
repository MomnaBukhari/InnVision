@extends('customer.customerlayout')

@section('title', 'Booking Confirmation')

@section('section1')
<div class="container mt-5">
    <h1>Booking Confirmation</h1>

    <div class="alert alert-success">
        <p>Your booking has been confirmed.</p>
        <p><strong>Room Number:</strong> {{ $booking->room->room_number }}</p>
        <p><strong>Start Date:</strong> {{ $booking->start_date->format('Y-m-d') }}</p>
        <p><strong>Duration:</strong> {{ $booking->duration_days }} days</p>
        <p><strong>Total Price:</strong> ${{ number_format($booking->total_price, 2) }}</p>
    </div>

    <form id="payment-form" method="POST">
        @csrf
        <input type="hidden" id="total-price" value="{{ $booking->total_price }}">
        <input type="hidden" id="booking-id" value="{{ $booking->id }}">
        <button id="checkout-button" class="btn btn-primary">Pay Now</button>
    </form>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var stripe = Stripe('{{ config('services.stripe.key') }}');
        var checkoutButton = document.getElementById('checkout-button');

        checkoutButton.addEventListener('click', function(event) {
            event.preventDefault();

            fetch('{{ route("create-checkout-session") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    total_price: document.getElementById('total-price').value,
                    booking_id: document.getElementById('booking-id').value
                })
            })
            .then(function (response) {
                return response.json();
            })
            .then(function (sessionId) {
                return stripe.redirectToCheckout({ sessionId: sessionId.id });
            })
            .then(function (result) {
                if (result.error) {
                    alert(result.error.message);
                }
            })
            .catch(function (error) {
                console.error('Error:', error);
            });
        });
    });
</script>
@endsection
