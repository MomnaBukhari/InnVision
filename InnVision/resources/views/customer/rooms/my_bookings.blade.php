@extends('customer.customerlayout')

@section('title', 'My Bookings')

@section('style')
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('section1')
    <div class="container mt-5">
        <h1>My Bookings</h1>

        @if ($rooms->isEmpty())
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
                        <th>Facilities</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rooms as $room)
                        <tr>
                            <td>{{ $room->room_number }}</td>
                            <td>{{ $room->description }}</td>
                            <td>{{ $room->max_occupancy }}</td>
                            <td>{{ $room->single_beds }}</td>
                            <td>{{ $room->floor }}</td>
                            <td>{{ $room->fare }}</td>
                            <td>{{ $room->branch->name }}</td>
                            <td>{{ $room->branch->hotel->name }}</td>
                            <td>
                                @foreach ($room->facilities as $facility)
                                    <span class="badge badge-info">{{ $facility->name }}</span>
                                @endforeach
                            </td>
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
