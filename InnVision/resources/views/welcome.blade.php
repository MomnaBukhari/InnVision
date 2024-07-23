@extends('mainlayout')

@section('title') Home @endsection

@section('pusherscript')
@endsection

@section('section1')
    <div class="section2">
    <h1>Home</h1>

    @auth
        <!-- User is authenticated -->
        @php
            $user = auth()->user();
        @endphp

        @if($user->role === 'admin')
            <p>Welcome back, Admin!</p>
            <a href="{{ route('admin.dashboard') }}">Go to Admin Dashboard</a>
        @elseif($user->role === 'hotel_owner')
            <p>Welcome back, Hotel Owner! {{$user->name}}</p>
            <a href="{{ route('owner.dashboard') }}">Go to Owner Dashboard</a>
        @elseif($user->role === 'customer')
            <p>Welcome back, Customer!</p>
            <a href="{{ route('customer.dashboard') }}">Go to Customer Dashboard</a>
        @else
            <p>Welcome back! You are already logged in.</p>
            <!-- Optional: Add a default link or message for other roles -->
        @endif
    @else
        <p>Please <a href="{{ route('login') }}">login</a> to access your dashboard.</p>
    @endauth
    </div>
@endsection
