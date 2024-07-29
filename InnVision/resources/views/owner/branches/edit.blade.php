@extends('owner.ownerlayout')

@section('title', 'Edit Branch')

@section('section1')
<div class="section1">
    <h1>Edit Branch</h1>

    <form action="{{ route('owner.branches.update', $branch) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="hotel_id">Hotel</label>
            <select id="hotel_id" name="hotel_id" class="form-control" required>
                @foreach ($hotels as $hotel)
                    <option value="{{ $hotel->id }}" {{ $branch->hotel_id == $hotel->id ? 'selected' : '' }}>{{ $hotel->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="name">Branch Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $branch->name) }}" required>
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" id="address" name="address" class="form-control" value="{{ old('address', $branch->address) }}" required>
        </div>

        <div class="form-group">
            <label for="is_main">Is Main Branch?</label>
            <select id="is_main" name="is_main" class="form-control" required>
                <option value="1" {{ $branch->is_main ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ !$branch->is_main ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <div class="form-group">
            <label>Facilities</label>
            @foreach ($facilities as $facility)
                <div class="form-check">
                    <input type="checkbox" id="facility_{{ $facility->id }}" name="facilities[]" value="{{ $facility->id }}" class="form-check-input" {{ $branch->facilities->contains($facility) ? 'checked' : '' }}>
                    <label for="facility_{{ $facility->id }}" class="form-check-label">{{ $facility->name }}</label>
                </div>
            @endforeach
            <div id="custom_facilities_list">
                @foreach ($branch->facilities as $facility)
                    @if ($facility->is_custom)
                        <div class="form-check">
                            <input type="checkbox" name="custom_facilities[]" value="{{ $facility->name }}" checked class="form-check-input">
                            <label class="form-check-label">{{ $facility->name }}</label>
                        </div>
                    @endif
                @endforeach
            </div>
            {{-- <div class="form-check">
                <input type="text" id="custom_facility_name" name="custom_facilities[]" class="form-control" placeholder="Enter custom facility name" style="display:none;">
                <button type="button" id="add_custom_facility" class="btn btn-secondary mt-2">Add Custom Facility</button>
            </div> --}}
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

@endsection
@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addCustomFacilityButton = document.getElementById('add_custom_facility');
        const customFacilityInput = document.getElementById('custom_facility');
        const customFacilitiesList = document.getElementById('custom_facilities_list');

        // Function to add custom facility
        function addCustomFacility() {
            const customFacility = customFacilityInput.value.trim();

            if (customFacility) {
                const container = document.createElement('div');
                container.className = 'custom-facility-item';

                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'custom_facilities[]';
                input.value = customFacility;

                const label = document.createElement('span');
                label.textContent = customFacility;
                label.className = 'custom-facility-label';

                const removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.className = 'btn btn-danger btn-sm ml-2';
                removeButton.textContent = 'Remove';
                removeButton.onclick = function () {
                    customFacilitiesList.removeChild(container);
                };

                container.appendChild(input);
                container.appendChild(label);
                container.appendChild(removeButton);

                customFacilitiesList.appendChild(container);

                customFacilityInput.value = '';
            }
        }

        addCustomFacilityButton.addEventListener('click', addCustomFacility);
    });
</script>
@endsection
