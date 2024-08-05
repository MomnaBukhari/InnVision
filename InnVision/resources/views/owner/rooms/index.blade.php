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
            cursor: pointer;
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
                <label for="sortOptions">Sort by:</label>
                <select id="sortOptions">
                    <option value="room_number">Room Number</option>
                    <option value="branch">Branch</option>
                    <option value="hotel">Hotel</option>
                    <option value="status">Status</option>
                    <option value="max_occupancy">Occupancy: Low to High</option>
                    <option value="single_beds">Single Beds</option>
                    <option value="fare_asc">Fare: Low to High</option>
                    <option value="fare_desc">Fare: High to Low</option>
                </select>

                @if ($rooms->isEmpty())
                    <p class="alert alert-warning">No rooms found.</p>
                @else
                    <table id="roomsTable">
                        <thead>
                            <tr>
                                <th>Room Number</th>
                                <th>Status</th>
                                <th>Booked By</th>
                                <th>Floor</th>
                                <th>Max Occupancy</th>
                                <th>Single Beds</th>
                                <th>Fare</th>
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
                                        <span class="badge {{ $room->is_booked ? 'badge-secondary' : 'badge-info' }}">
                                            {{ $room->is_booked ? 'Booked' : 'Available' }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $room->is_booked ? ($room->bookedBy ? $room->bookedBy->name : 'Nobody') : 'Nobody' }}
                                    </td>
                                    <td>{{ $room->floor }}</td>
                                    <td>{{ $room->max_occupancy }}</td>
                                    <td>{{ $room->single_beds }}</td>
                                    <td>{{ $room->fare }}</td>
                                    <td>{{ $room->description }}</td>
                                    <td>{{ $room->branch ? $room->branch->name : 'No Branch' }}</td>
                                    <td>{{ $room->branch && $room->branch->hotel ? $room->branch->hotel->name : 'No Hotel' }}
                                    </td>
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

    <script>
        document.getElementById('sortOptions').addEventListener('change', function() {
            sortTable(this.value);
        });

        function sortTable(sortBy) {
            const table = document.getElementById('roomsTable');
            const rows = Array.from(table.rows).slice(1); // Skip header row
            let compare;

            switch (sortBy) {
                case 'room_number':
                    compare = (a, b) => a.cells[0].innerText.localeCompare(b.cells[0].innerText);
                    break;
                case 'branch':
                    compare = (a, b) => a.cells[7].innerText.localeCompare(b.cells[7].innerText);
                    break;
                case 'hotel':
                    compare = (a, b) => a.cells[8].innerText.localeCompare(b.cells[8].innerText);
                    break;
                case 'status':
                    compare = (a, b) => a.cells[1].innerText.localeCompare(b.cells[1].innerText);
                    break;
                case 'max_occupancy':
                    compare = (a, b) => parseInt(a.cells[4].innerText) - parseInt(b.cells[4].innerText);
                    break;
                case 'single_beds':
                    compare = (a, b) => parseInt(a.cells[5].innerText) - parseInt(b.cells[5].innerText);
                    break;
                case 'fare_asc':
                    compare = (a, b) => parseFloat(a.cells[6].innerText) - parseFloat(b.cells[6].innerText);
                    break;
                case 'fare_desc':
                    compare = (a, b) => parseFloat(b.cells[6].innerText) - parseFloat(a.cells[6].innerText);
                    break;
                default:
                    return;
            }

            rows.sort(compare);
            rows.forEach(row => table.appendChild(row));
        }
    </script>
@endsection
