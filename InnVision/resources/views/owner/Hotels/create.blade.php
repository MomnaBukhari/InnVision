@extends('owner.ownerlayout')

@section('title', 'Add New Hotel')

@section('section1')
    <div class="section1">
        <div class="section1-part1">
            <a href="{{ route('owner.hotels.index') }}" class="side-menu-list-item side-menu-list-item-action">Back to List</a>
        </div>
        <div class="section1-part2">
            <h1>Add New Hotel</h1>
            <form action="{{ route('owner.hotels.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Hotel Name:</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="stars">Stars:</label>
                    <input type="number" id="stars" name="stars" class="form-control" min="1" max="7">
                </div>
                <button type="submit" class="btn btn-primary">Add Hotel</button>
            </form>
        </div>
    </div>
@endsection
