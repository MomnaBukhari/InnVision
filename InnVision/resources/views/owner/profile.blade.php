@extends('owner.ownerlayout')

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
            @include('Owner.Ownercomponents.profilesubmenu')
        </div>
        <div class="section1-part2">
            <div class="section1-part2-display">
                <h2>Profile Information</h2>
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Role:</strong> {{ $user->role }}</p>

                @if ($user->hotel_name)
                    <p><strong>Hotel Name:</strong> {{ $user->hotel_name }}</p>
                @else
                    <p><strong>Hotel Name:</strong> <span class="notsetyet">Not Set Yet</span></p>
                @endif

                @if ($user->hotel_stars)
                    <p><strong>Hotel Stars:</strong> {{ $user->hotel_stars }}</p>
                @else
                    <p><strong>Hotel Stars:</strong> <span class="notsetyet">Not Set Yet</span></p>
                @endif


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
                <!-- other profile information to display -->
            </div>
        </div>
    </div>
@endsection
