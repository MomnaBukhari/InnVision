@extends('admin.adminlayout')

@section('title', 'Edit - Profile')

@section('section1')
    <div class="section1">
        <div class="section1-part1">
            @include('Admin.Admincomponents.profilesubmenu')
        </div>
        <div class="section1-part2">
            <div class="section1-part2-display">
                <h2>Edit Profile</h2>
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="about">About:</label>
                        <textarea id="about" name="about">{{ old('about', $user->about) }}</textarea>
                        @error('about')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                            required readonly>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="contact_number">Contact Number:</label>
                        <input type="text" id="contact_number" name="contact_number"
                            value="{{ old('contact_number', $user->contact_number) }}">
                        @error('contact_number')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="address">Address:</label>
                        <input type="text" id="address" name="address" value="{{ old('address', $user->address) }}">
                        @error('address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password">
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password:</label>
                        <input type="password" id="password_confirmation" name="password_confirmation">
                    </div>

                    <div class="form-group">
                        <label for="profile_picture">Profile Picture:</label>
                        <input type="file" id="profile_picture" name="profile_picture">
                        @error('profile_picture')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        @if ($user->profile_picture)
                            <img src="{{ $user->profile_picture }}" alt="{{ $user->name }}'s Profile Picture"
                                style="width: 150px; height: 150px; border-radius: 50%; margin-top: 10px;">
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>
            </div>
        </div>
    </div>
@endsection
