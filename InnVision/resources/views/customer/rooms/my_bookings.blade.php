@extends('customer.customerlayout')

@section('title', 'My Bookings')

@section('style')
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('section1')
    <div class="container mt-5">
        <h1>My Bookings</h1>

        @if ($bookings->isEmpty())
            <div class="alert alert-warning" role="alert">
                You have not booked any rooms yet.
            </div>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Room Number</th>
                        <th>Description</th>
                        <th>Maximum Occupancy</th>
                        <th>Single Bed Available</th>
                        <th>Floor</th>
                        <th>Fare</th>
                        <th>Branch</th>
                        <th>Hotel</th>
                        <th>Booking Start Date</th>
                        <th>Duration (Days)</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $booking)
                        @php
                            $room = $booking->room;
                            $branch = $room->branch;
                            $hotel = $branch->hotel;
                        @endphp
                        <tr>
                            <td>{{ $room->room_number }}</td>
                            <td>{{ $room->description }}</td>
                            <td>{{ $room->max_occupancy }}</td>
                            <td>{{ $room->single_beds }}</td>
                            <td>{{ $room->floor }}</td>
                            <td>{{ $room->fare }}</td>
                            <td>{{ $branch->name }}</td>
                            <td>{{ $hotel->name }}</td>
                            <td>{{ $booking->start_date->format('Y-m-d') }}</td>
                            <td>{{ $booking->duration_days }}</td>
                            <td>${{ $booking->total_price }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
