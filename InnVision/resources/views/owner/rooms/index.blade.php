@extends('owner.ownerlayout')

@section('title', 'Rooms')

@section('style')
    <style>
        .table-container {
            padding: 20px;
            border-radius: 8px;

            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
            background-color: #ffffff;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: #fff;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .badge-info {
            padding: 5px 10px;
            background-color: #17a2b8;
            color: #fff;
            border-radius: 5px;
            font-size: 12px;
        }

        .badge-secondary {
            padding: 5px 10px;
            background-color: #6c757d;
            color: #fff;
            border-radius: 5px;
            font-size: 12px;
        }

        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ffeeba;
        }
    </style>
@endsection

@section('section1')
    <div class="section1">
        <div class="section1-part1">
            @include('Owner.Ownercomponents.roomsubmenu') <!-- Include your submenu here -->
        </div>
        <div class="section1-part2">
            <div class="table-container">
                {{-- <h1>Rooms</h1>
                <a href="{{ route('owner.rooms.create') }}" class="btn btn-primary mb-3">Add New Room</a> --}}

                @if ($rooms->isEmpty())
                    <p class="alert alert-warning">No rooms found.</p>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th>Room Number</th>
                                <th>Status</th>
                                <th>Booked By</th>
                                <th>Floor</th>
                                <th>Max Occupancy</th>
                                <th>Single Beds</th>
                                <th>Description</th>
                                <th>Branch</th>
                                <th>Hotel</th>
                                <th>Facilities</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rooms as $room)
                                <tr>
                                    <td>{{ $room->room_number }}</td>
                                    <td>
                                        <span
                                            class="badge {{ $room->status === 'available' ? 'badge-info' : 'badge-secondary' }}">
                                            {{ ucfirst($room->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $room->status === 'booked' ? $room->bookedBy->name : 'Nobody' }}</td>
                                    <td>{{ $room->floor }}</td>
                                    <td>{{ $room->max_occupancy }}</td>
                                    <td>{{ $room->single_beds }}</td>
                                    <td>{{ $room->description }}</td>
                                    <td>{{ $room->branch->name }}</td>
                                    <td>{{ $room->branch->hotel->name }}</td>
                                    <td>
                                        @foreach ($room->facilities as $facility)
                                            <span class="badge badge-info">{{ $facility->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <a href="{{ route('owner.rooms.edit', $room) }}" class="btn btn-warning">Edit</a>
                                        <form action="{{ route('owner.rooms.destroy', $room) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection
