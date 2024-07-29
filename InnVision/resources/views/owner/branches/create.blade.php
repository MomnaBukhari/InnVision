@extends('owner.ownerlayout')

@section('title', 'Create Branch')

@section('section1')
    <div class="section1">
        <div class="section1-part1">
            @include('Owner.Ownercomponents.branchsubmenu')
        </div>
        <div class="section1-part2">
            <div class="section1-part2-display">
                <h1>Create Branch</h1>

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('owner.branches.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="hotel_id">Hotel:</label>
                        <select id="hotel_id" name="hotel_id" class="form-control" required>
                            @if ($hotels && $hotels->count() > 0)
                                @foreach ($hotels as $hotel)
                                    <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                                @endforeach
                            @else
                                <option value="">No hotels available</option>
                            @endif
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="name">Branch Name:</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="address">Address:</label>
                        <input type="text" id="address" name="address" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="is_main">Branch Type:</label>
                        <select id="is_main" name="is_main" class="form-control" required>
                            <option value="1">Main Branch</option>
                            <option value="0">Sub Branch</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Facilities:</label>
                        <div id="facilities-container">
                            @if ($staticFacilities && $staticFacilities->count() > 0)
                                @foreach ($staticFacilities as $facility)
                                    <div>
                                        <input type="checkbox" id="facility_{{ $facility->id }}" name="facilities[]"
                                            value="{{ $facility->id }}">
                                        <label for="facility_{{ $facility->id }}">{{ $facility->name }}</label>
                                    </div>
                                @endforeach
                            @else
                                <p>No facilities available</p>
                            @endif
                        </div>

                        <div class="form-group mt-3">
                            <input type="text" id="custom_facility" placeholder="Add custom facility"
                                class="form-control">
                            <button type="button" id="add_custom_facility" class="btn btn-secondary mt-2">Add Custom
                                Facility</button>
                            <div id="custom_facilities_list" class="mt-2"></div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Create Branch</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('add_custom_facility').addEventListener('click', function() {
            const customFacility = document.getElementById('custom_facility').value;
            if (customFacility) {
                const list = document.getElementById('custom_facilities_list');
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'custom_facilities[]';
                input.value = customFacility;

                const label = document.createElement('span');
                label.textContent = customFacility;
                label.classList.add('custom-facility-label');

                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'btn btn-danger btn-sm ml-2';
                button.textContent = 'Remove';
                button.onclick = function() {
                    list.removeChild(container);
                };

                const container = document.createElement('div');
                container.classList.add('custom-facility-item');
                container.appendChild(input);
                container.appendChild(label);
                container.appendChild(button);

                list.appendChild(container);

                // Clear input
                document.getElementById('custom_facility').value = '';
            }
        });
    </script>

    <style>
        .custom-facility-label {
            margin-right: 10px;
        }

        .custom-facility-item {
            margin-bottom: 5px;
        }

        .notsetyet {
            color: gray;
        }

        .alert {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
@endsection
