@extends('customer.customerlayout')

@section('title', 'Payment Success')

@section('section1')

<div class="container mt-5">

    <h1>Payment Successful!</h1>

    <p><strong>Booking ID:</strong> {{ $booking->id }}</p>

    <p><strong>Hotel:</strong> {{ $room->branch->hotel->name ?? 'N/A' }}</p>

    <p><strong>Branch:</strong> {{ $room->branch->name ?? 'N/A' }}</p>

    <p><strong>Room Number:</strong> {{ $room->room_number }}</p>

    <p><strong>Booked By:</strong> {{ $user->name }}</p>

    <p><strong>Total Price:</strong> ${{ $booking->total_price }}</p>

    <p>Your room has been successfully booked. Thank you for your payment!</p>

</div>

@endsection
