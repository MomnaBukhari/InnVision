@extends('admin.adminlayout')

@section('title', 'Profile')
@section('style')
    <style>
        .notsetyet {
            color: gray;
        }
    </style>
@endsection

@section('section1')
    <div class="section1">
        <div class="section1-part1">
            <img src="{{ $user->profile_picture ? $user->profile_picture : '/images/default_profile_picture.jpg' }}"
            alt="{{ $user->name }}'s Profile Picture" style="width: 150px; height: 150px; border-radius: 50%;">
            @include('Admin.Admincomponents.profilesubmenu')
        </div>
        <div class="section1-part2">
            <div class="section1-part2-display">
                <h2>Profile Information</h2>
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Role:</strong> {{ $user->role }}</p>
                @if ($user->contact_number)
                    <p><strong>Contact Number:</strong> {{ $user->contact_number }}</p>
                @else
                    <p><strong>Contact Number:</strong> <span class="notsetyet">Not Set Yet</span></p>
                @endif

                @if ($user->address)
                    <p><strong>Address:</strong> {{ $user->address }}</p>
                @else
                    <p><strong>Address:</strong> <span class="notsetyet">Not Set Yet</span></p>
                @endif

                @if ($user->about)
                    <p><strong>About:</strong> {{ $user->about }}</p>
                @else
                    <p><strong>About:</strong> <span class="notsetyet">Not Set Yet</span></p>
                @endif

                <!-- Add any other profile information you want to display -->
            </div>
        </div>
    </div>
@endsection
