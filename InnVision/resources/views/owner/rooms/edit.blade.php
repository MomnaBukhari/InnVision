@extends('owner.ownerlayout')

@section('title', 'Edit Room')

@section('style')
    <style>
        .form-container {
            padding: 20px;
            border-radius: 5px;
            background-color: #f9f9f9;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: #fff;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
@endsection

@section('section1')
    <div class="section1">
        <div class="section1-part1">
            @include('Owner.Ownercomponents.roomsubmenu') <!-- Include your submenu here -->
        </div>
        <div class="section1-part2">
            <div class="form-container">
                <h1>Edit Room</h1>

                <form action="{{ route('owner.rooms.update', $room) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="branch_id">Branch:</label>
                        <select id="branch_id" name="branch_id" class="form-control" required>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}" {{ $room->branch_id == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="room_number">Room Number:</label>
                        <input type="text" id="room_number" name="room_number" class="form-control" value="{{ old('room_number', $room->room_number) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select id="status" name="status" class="form-control" required>
                            <option value="available" {{ $room->status == 'available' ? 'selected' : '' }}>Available</option>
                            <option value="booked" {{ $room->status == 'booked' ? 'selected' : '' }}>Booked</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="booked_by">Booked By:</label>
                        <select id="booked_by" name="booked_by" class="form-control">
                            <option value="">Select Customer (if booked)</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="floor">Floor:</label>
                        <input type="number" id="floor" name="floor" class="form-control" value="{{ old('floor', $room->floor) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="max_occupancy">Max Occupancy:</label>
                        <input type="number" id="max_occupancy" name="max_occupancy" class="form-control" value="{{ old('max_occupancy', $room->max_occupancy) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="single_beds">Single Beds:</label>
                        <input type="number" id="single_beds" name="single_beds" class="form-control" value="{{ old('single_beds', $room->single_beds) }}" min="0">
                    </div>

                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea id="description" name="description" class="form-control">{{ old('description', $room->description) }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Room</button>
                </form>
            </div>
        </div>
    </div>
@endsection
