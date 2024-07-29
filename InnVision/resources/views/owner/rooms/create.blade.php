@extends('owner.ownerlayout')

@section('title', 'Create Room')

@section('section1')
    <h1>Create Room</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('owner.rooms.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="branch_id">Branch:</label>
            <select id="branch_id" name="branch_id" class="form-control" required>
                @foreach ($branches as $branch)
                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="room_number">Room Number:</label>
            <input type="text" id="room_number" name="room_number" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="status">Status:</label>
            <select id="status" name="status" class="form-control" required>
                <option value="available">Available</option>
                <option value="booked">Booked</option>
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
            <input type="number" id="floor" name="floor" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="max_occupancy">Max Occupancy:</label>
            <input type="number" id="max_occupancy" name="max_occupancy" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="single_beds">Single Beds:</label>
            <input type="number" id="single_beds" name="single_beds" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label>Facilities:</label>
            @foreach ($facilities as $facility)
                <div>
                    <input type="checkbox" id="facility_{{ $facility->id }}" name="facilities[]" value="{{ $facility->id }}">
                    <label for="facility_{{ $facility->id }}">{{ $facility->name }}</label>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">Create Room</button>
    </form>
@endsection

@section('style')
    <style>
        /* Custom styles */
    </style>
@endsection
