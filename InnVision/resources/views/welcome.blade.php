@extends('mainlayout')

@section('title') Home @endsection
@section('')
@section('pusherscript')
@endsection

@section('section1')
    <div class="section2">
        <div>
            <h1>Home</h1>
            @auth
                <!-- User is authenticated -->
                @php
                    $user = auth()->user();
                @endphp

                @if($user->role === 'admin')
                    <p>Welcome back, {{$user->name}}!</p>
                    <a href="{{ route('admin.dashboard') }}" class="button">Go to Admin Dashboard</a>
                @elseif($user->role === 'hotel_owner')
                    <p>Welcome back, {{$user->name}}!</p>
                    <a href="{{ route('owner.dashboard') }}" class="button">Go to Owner Dashboard</a>
                @elseif($user->role === 'customer')
                    <p>Welcome back, {{$user->name}}!</p>
                    <a href="{{ route('customer.dashboard') }}" class="button">Go to Customer Dashboard</a>
                @else
                    <p>Welcome back! You are already logged in.</p>
                    <!-- Optional: Add a default link or message for other roles -->
                @endif
            @else
                <p>Please <a href="{{ route('login') }}">login</a> to access your dashboard.</p>
            @endauth
        </div>
    </div>


    {{--


    --}}
@endsection
