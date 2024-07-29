@extends('admin.adminlayout')

@section('title', $hotel->name . ' - Hotel Details')

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
    </style>
@endsection

@section('section1')
    <div class="section1">
        <div class="section1-part1">
            <!-- Any additional content -->
        </div>
        <div class="section1-part2">
            <div class="section1-part2-display">
                <h2>{{ $hotel->name }} - Hotel Details</h2>
                <h2>Branches</h2>

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <table>
                    <thead>
                        <tr>
                            <th>Branch Name</th>
                            <th>Number of Rooms</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hotel->branches as $branch)
                            <tr>
                                <td>{{ $branch->name }}</td>
                                <td>{{ $branch->rooms->count() }}</td>
                                <td>
                                    <form action="{{ route('admin.deleteBranch', $branch->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete Branch</button>
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Room Number</th>
                                                <th>Availability Status</th>
                                                <th>Booked By</th>
                                                <th>Floor Number</th>
                                                <th>Maximum Occupancy</th>
                                                <th>Number of Single Beds</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($branch->rooms as $room)
                                                <tr>
                                                    <td>{{ $room->room_number }}</td>
                                                    <td>{{ $room->availability_status ? 'Booked' : 'Available' }}</td>
                                                    <td>{{ $room->bookedBy ? $room->bookedBy->name : 'N/A' }}</td>
                                                    <td>{{ $room->floor_number }}</td>
                                                    <td>{{ $room->maximum_occupancy }}</td>
                                                    <td>{{ $room->number_of_single_beds }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6">No rooms available.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

