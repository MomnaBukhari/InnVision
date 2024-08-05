@extends('customer.customerlayout')

@section('title')
    Branches of {{ $branch->hotel->name }}
@endsection

@section('style')
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('section1')
<div class="container mt-5">
    <h1>{{ $branch->name }}</h1>
    <p><strong>Location:</strong> {{ $branch->address }}</p>

    <h2>Available Rooms</h2>

    <form method="GET" action="{{ route('customer.branch.show', $branch->id) }}" class="form-inline mb-3">
        <input type="text" name="search" id="search" class="form-control w-25" placeholder="Search rooms..." value="{{ request()->input('search') }}">

        <select name="facility" id="facility" class="form-control w-25 ml-2">
            <option value="">Select Facility</option>
            @foreach ($facilities as $id => $name)
                <option value="{{ $name }}" {{ request()->input('facility') == $name ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>

        <input type="number" name="min_fare" id="min_fare" class="form-control w-25 ml-2" placeholder="Min Fare" value="{{ request()->input('min_fare') }}">
        <input type="number" name="max_fare" id="max_fare" class="form-control w-25 ml-2" placeholder="Max Fare" value="{{ request()->input('max_fare') }}">

        <button type="submit" class="btn btn-primary ml-2">Search</button>
        <a href="{{ route('customer.branch.show', $branch->id) }}" class="btn btn-secondary ml-2">Clear Search</a>
    </form>

    @if ($rooms->isEmpty())
        <div class="alert alert-warning" role="alert">
            No available rooms.
        </div>
    @else
        <div class="mb-3">
            <label for="sort-by" class="form-label">Sort By:</label>
            <select id="sort-by" class="form-control">
                <option value="room_number_asc">Room Number: Min to Max</option>
                <option value="room_number_desc">Room Number: Max to Min</option>
                <option value="occupancy_asc">Occupancy: Min to Max</option>
                <option value="occupancy_desc">Occupancy: Max to Min</option>
                <option value="single_beds_asc">Single Bed Available: Min to Max</option>
                <option value="single_beds_desc">Single Bed Available: Max to Min</option>
                <option value="floor_asc">Floor: Ascending</option>
                <option value="floor_desc">Floor: Descending</option>
                <option value="fare_asc">Fare: Low to High</option>
                <option value="fare_desc">Fare: High to Low</option>
            </select>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Room Number</th>
                    <th>Description</th>
                    <th>Maximum Occupancy</th>
                    <th>Single Bed Available</th>
                    <th>Floor</th>
                    <th>Fare</th>
                    <th>Facilities</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="rooms-table">
                @foreach ($rooms as $room)
                    <tr>
                        <td>{{ $room->room_number }}</td>
                        <td>{{ $room->description }}</td>
                        <td>{{ $room->max_occupancy }}</td>
                        <td>{{ $room->single_beds }}</td>
                        <td>{{ $room->floor }}</td>
                        <td>{{ $room->fare }}</td>
                        <td>
                            @foreach ($room->facilities as $facility)
                                <span class="badge badge-info">{{ $facility->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            @if (!$room->is_booked)
                                <a href="{{ route('book.form', $room->id) }}" class="btn btn-primary">Book Now</a>
                            @else
                                <button class="btn btn-secondary" disabled>Booked</button>
                            @endif
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
    <script>
        $(document).ready(function() {
            $('#sort-by').change(function() {
                var sortBy = $(this).val();
                var rows = $('#rooms-table tr').get();

                rows.sort(function(a, b) {
                    var A, B;
                    switch (sortBy) {
                        case 'room_number_asc':
                            A = parseInt($(a).children('td').eq(0).text());
                            B = parseInt($(b).children('td').eq(0).text());
                            return A - B;
                        case 'room_number_desc':
                            A = parseInt($(a).children('td').eq(0).text());
                            B = parseInt($(b).children('td').eq(0).text());
                            return B - A;
                        case 'occupancy_asc':
                            A = parseInt($(a).children('td').eq(2).text());
                            B = parseInt($(b).children('td').eq(2).text());
                            return A - B;
                        case 'occupancy_desc':
                            A = parseInt($(a).children('td').eq(2).text());
                            B = parseInt($(b).children('td').eq(2).text());
                            return B - A;
                        case 'single_beds_asc':
                            A = parseInt($(a).children('td').eq(3).text());
                            B = parseInt($(b).children('td').eq(3).text());
                            return A - B;
                        case 'single_beds_desc':
                            A = parseInt($(a).children('td').eq(3).text());
                            B = parseInt($(b).children('td').eq(3).text());
                            return B - A;
                        case 'floor_asc':
                            A = parseInt($(a).children('td').eq(4).text());
                            B = parseInt($(b).children('td').eq(4).text());
                            return A - B;
                        case 'floor_desc':
                            A = parseInt($(a).children('td').eq(4).text());
                            B = parseInt($(b).children('td').eq(4).text());
                            return B - A;
                        case 'fare_asc':
                            A = parseFloat($(a).children('td').eq(5).text().replace('$', ''));
                            B = parseFloat($(b).children('td').eq(5).text().replace('$', ''));
                            return A - B;
                        case 'fare_desc':
                            A = parseFloat($(a).children('td').eq(5).text().replace('$', ''));
                            B = parseFloat($(b).children('td').eq(5).text().replace('$', ''));
                            return B - A;
                        default:
                            return 0;
                    }
                });

                $.each(rows, function(index, row) {
                    $('#rooms-table').append(row);
                });
            });
        });
    </script>
@endsection
