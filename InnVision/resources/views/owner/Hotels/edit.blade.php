<!-- resources/views/owner/hotels/edit.blade.php -->
@extends('owner.ownerlayout')

@section('title', 'Edit Hotel')

@section('section1')
    <div class="section1">
        <div class="section1-part1">
            <a href="{{ route('owner.hotels.index') }}" class="side-menu-list-item side-menu-list-item-action">Back to List</a>
        </div>
        <div class="section1-part2">
            <h1>Edit Hotel</h1>
            <form action="{{ route('owner.hotels.update', $hotel->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Hotel Name:</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ $hotel->name }}" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" class="form-control">{{ $hotel->description }}</textarea>
                </div>
                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" class="form-control" value="{{ $hotel->address }}" required>
                </div>
                <div class="form-group">
                    <label for="stars">Stars:</label>
                    <input type="number" id="stars" name="stars" class="form-control" value="{{ $hotel->stars }}" min="1" max="7">
                </div>
                <button type="submit" class="btn btn-primary">Update Hotel</button>
            </form>
        </div>
    </div>
@endsection
