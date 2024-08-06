@extends('owner.ownerlayout')

@section('title', 'Edit Room')

@section('section1')
    <div class="section1">
        <div class="section1-part1">
            @include('Owner.Ownercomponents.roomsubmenu') <!-- Include your submenu here -->
        </div>
        <div class="section1-part2">
            <h1>Edit Room</h1>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('errors'))
                <div class="alert alert-danger">
                    {{ session('errors') }}
                </div>
            @endif

            <form action="{{ route('owner.rooms.update', $room) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="hotel_id">Hotel:</label>
                    <select id="hotel_id" name="hotel_id" class="form-control" required>
                        @foreach ($hotels as $hotel)
                            <option value="{{ $hotel->id }}"
                                {{ $room->branch && $room->branch->hotel_id == $hotel->id ? 'selected' : '' }}>
                                {{ $hotel->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

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
                    <input type="text" id="room_number" name="room_number" class="form-control"
                        value="{{ $room->room_number }}" required>
                </div>

                <div class="form-group">
                    <label for="status">Status:</label>
                    <select id="status" name="status" class="form-control" required>
                        <option value="available" {{ !$room->is_booked ? 'selected' : '' }}>Available</option>
                        <option value="booked" {{ $room->is_booked ? 'selected' : '' }}>Booked</option>
                    </select>
                </div>

                <div class="form-group" id="booked_by_group" style="{{ $room->is_booked ? '' : 'display:none;' }}">
                    <label for="booked_by">Booked By:</label>
                    <select id="booked_by" name="booked_by" class="form-control">
                        <option value="">Select Customer (if booked)</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}" {{ $room->customer_id == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="floor">Floor:</label>
                    <input type="number" id="floor" name="floor" class="form-control" value="{{ $room->floor }}"
                        required>
                </div>

                <div class="form-group">
                    <label for="max_occupancy">Max Occupancy:</label>
                    <input type="number" id="max_occupancy" name="max_occupancy" class="form-control"
                        value="{{ $room->max_occupancy }}" required>
                </div>

                <div class="form-group">
                    <label for="single_beds">Single Beds:</label>
                    <input type="number" id="single_beds" name="single_beds" class="form-control"
                        value="{{ $room->single_beds }}" required>
                </div>

                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" class="form-control">{{ $room->description }}</textarea>
                </div>

                <div class="form-group">
                    <label for="facilities">Facilities:</label>
                    @foreach ($facilities as $facility)
                        <div>
                            <input type="checkbox" name="facilities[]" value="{{ $facility->id }}"
                                id="facility{{ $facility->id }}"
                                {{ $room->facilities->contains($facility) ? 'checked' : '' }}>
                            <label for="facility{{ $facility->id }}">{{ $facility->name }}</label>
                        </div>
                    @endforeach
                </div>

                <button type="submit" class="btn btn-primary">Update Room</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('status').addEventListener('change', function() {
            const bookedByGroup = document.getElementById('booked_by_group');
            bookedByGroup.style.display = this.value === 'booked' ? '' : 'none';
        });

        // Trigger the status change event on page load
        document.getElementById('status').dispatchEvent(new Event('change'));
    </script>
@endsection
