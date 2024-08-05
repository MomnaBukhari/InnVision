<!-- resources/views/customer/booking-confirmation.blade.php -->
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
</div>
@endsection
