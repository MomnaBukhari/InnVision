@extends('customer.customerlayout')

@section('title')
    {{ $hotel->name }}
@endsection

@section('style')
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('section1')
<div class="container mt-5">
    <h1>{{ $hotel->name }}</h1>
    <p>{{ $hotel->description }}</p>
    <p><strong>Service (stars):</strong> {{ $hotel->stars }}</p>
    <p><strong>Location:</strong> {{ $hotel->address }}</p>

    <h2>Branches</h2>

    <form method="GET" action="{{ route('customer.hotel.show', $hotel->id) }}" class="form-inline mb-3">
        <input type="text" name="search" id="search" class="form-control w-25" placeholder="Search branches..." value="{{ request()->input('search') }}">

        <select name="facility" id="facility" class="form-control w-25 ml-2">
            <option value="">Select Facility</option>
            @foreach ($facilities as $id => $name)
                <option value="{{ $name }}" {{ request()->input('facility') == $name ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-primary ml-2">Search</button>
        <a href="{{ route('customer.hotel.show', $hotel->id) }}" class="btn btn-secondary ml-2">Clear Search</a>
    </form>

    @if ($branches->isEmpty())
        <div class="alert alert-warning" role="alert">
            No branches available.
        </div>
    @else
        <ul class="list-group">
            @foreach ($branches as $branch)
                <li class="list-group-item">
                    <h3>{{ $branch->name }} ({{ $branch->rooms->count() }} rooms)</h3>
                    <p>{{ $branch->address }}</p>
                    <p><strong>Facilities:</strong></p>
                    <div>
                        @foreach ($branch->facilities as $facility)
                            <span class="badge badge-info">{{ $facility->name }}</span>
                        @endforeach
                    </div>
                    <a href="{{ route('customer.branch.show', $branch->id) }}" class="btn btn-primary mt-2">View Rooms</a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
