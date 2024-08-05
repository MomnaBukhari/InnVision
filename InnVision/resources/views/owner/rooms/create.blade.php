@extends('owner.ownerlayout')

@section('title', 'Create Room')

@section('section1')
    <div class="section1">
        <div class="section1-part1">
            @include('Owner.Ownercomponents.roomsubmenu') <!-- Include your submenu here -->
        </div>
        <div class="section1-part2">
            <h1>Create Room</h1>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('owner.rooms.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="hotel_id">Hotel:</label>
                    <select id="hotel_id" name="hotel_id" class="form-control" required>
                        <option value="">Select Hotel</option>
                        @foreach ($hotels as $hotel)
                            <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="branch_id">Branch:</label>
                    <select id="branch_id" name="branch_id" class="form-control" required>
                        <option value="">Select Branch</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="room_number">Room Number:</label>
                    <input type="text" id="room_number" name="room_number" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="is_booked">Status:</label>
                    <select id="is_booked" name="is_booked" class="form-control" required>
                        {{-- <option readonly>Availibility</option> --}}
                        <option value="0">Available</option>
                        <option value="1">Booked</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="customer_id">Booked By:</label>
                    <select id="customer_id" name="customer_id" class="form-control">
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
                    <label for="fare">Fare:</label>
                    <input type="number" step="0.01" id="fare" name="fare" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" class="form-control"></textarea>
                </div>

                <div class="form-group">
                    <label>Facilities:</label>
                    @foreach ($facilities as $facility)
                        <div>
                            <input type="checkbox" id="facility_{{ $facility->id }}" name="facilities[]"
                                value="{{ $facility->id }}">
                            <label for="facility_{{ $facility->id }}">{{ $facility->name }}</label>
                        </div>
                    @endforeach
                </div>

                <button type="submit" class="btn btn-primary">Create Room</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('hotel_id').addEventListener('change', function () {
            const hotelId = this.value;
            const branchSelect = document.getElementById('branch_id');

            // Clear the branch dropdown
            branchSelect.innerHTML = '<option value="">Select Branch</option>';

            if (hotelId) {
                fetch(`/owner/hotels/${hotelId}/branches`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(branch => {
                            const option = document.createElement('option');
                            option.value = branch.id;
                            option.textContent = branch.name;
                            branchSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching branches:', error));
            }
        });
    </script>
@endsection

@section('style')
    <style>
        /* Custom styling */
    </style>
@endsection
