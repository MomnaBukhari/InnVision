@extends('mainlayout')

@section('title') Home @endsection

@section('styles')

@endsection

@section('section1')
<style>
    /* Enhanced Header Styles */
    .header-content {
        padding: 8% 2%;
        background-color: #800020;
        color: #fff;
        /* border-radius: 15px; */
        text-align: center;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
    }

    .header-content h1 {
        font-size: 3.5em;
        margin-bottom: 10px;
        letter-spacing: 2px;
    }

    .header-content p {
        font-size: 1.5em;
        font-weight: 300;
        margin-bottom: 0;
    }

    /* Section Styles */
    .section {
        padding: 80px 20px;
        text-align: center;
        border-radius: 15px;
        max-width: 1000px;
        margin: 30px auto;
        background-color: #ffffff;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
    }

    .section h1, .section h2 {
        font-size: 2.8em;
        margin-bottom: 20px;
        color: #800020;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .section p {
        font-size: 1.2em;
        line-height: 1.8;
        margin-bottom: 20px;
        color: #555;
    }

    .features-list {
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
    }

    .feature-item {
        width: 30%;
        background-color: #f9f9f9;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .feature-item:hover {
        transform: translateY(-5px);
        box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.15);
    }

    .feature-item h3 {
        font-size: 1.8em;
        color: #800020;
        margin-bottom: 15px;
    }

    .feature-item p {
        font-size: 1.1em;
        line-height: 1.6;
        color: #666;
    }

    .cta-section {
        padding: 50px;
        background-color: #800020;
        color: #fff;
        text-align: center;
        border-radius: 15px;
        margin-top: 50px;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
    }

    .cta-section h2 {
        font-size: 2.5em;
        margin-bottom: 20px;
    }

    .cta-section a.button {
        background-color: #fff;
        color: #800020;
        padding: 15px 30px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 1.3em;
        transition: background-color 0.3s, color 0.3s;
    }

    .cta-section a.button:hover {
        background-color: #f5f5f5;
        color: #a0002f;
    }
    .button {
        background-color: #800020;
        color: #ffffff;
        padding: 15px 30px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 1.3em;
        transition: background-color 0.3s, color 0.3s;
    }
</style>
    <div class="header">
        <div class="header-content">
            <h1>Invision</h1>
            <p>Your Ultimate Hotel Management & Booking Platform</p>
        </div>
    </div>

    <div class="section">
        <h1>Welcome to Invision</h1>
        <p>Invision is your all-in-one solution for seamless hotel management and booking. Whether you're a hotel owner looking to streamline operations or a customer searching for the perfect stay, Invision has you covered.</p>
        @auth
            @php
                $user = auth()->user();
            @endphp

            @if($user->role === 'admin')
                <p>Welcome back, {{$user->name}}! Manage your system effortlessly.</p>
                <a href="{{ route('admin.dashboard') }}" class="button">Go to Admin Dashboard</a>
            @elseif($user->role === 'hotel_owner')
                <p>Welcome back, {{$user->name}}! Ready to manage your properties?</p>
                <a href="{{ route('owner.dashboard') }}" class="button">Go to Owner Dashboard</a>
            @elseif($user->role === 'customer')
                <p>Welcome back, {{$user->name}}! Time to book your next stay.</p>
                <a href="{{ route('customer.dashboard') }}" class="button">Go to Customer Dashboard</a>
            @else
                <p>Welcome back! You are already logged in.</p>
            @endif
        @else
            <p><a href="{{ route('login') }}" class="button">Login</a>  <a href="{{ route('register') }}" class="button">Register</a></p>
        @endauth
    </div>

    <div class="section">
        <h2>Our Features</h2>
        <div class="features-list">
            <div class="feature-item">
                <h3>For Hotel Owners</h3>
                <p>Effortlessly manage your hotel, track bookings, and optimize your operations with our intuitive tools tailored specifically for hotel owners.</p>
            </div>
            <div class="feature-item">
                <h3>For Customers</h3>
                <p>Explore a wide range of hotels, find the perfect room, and book with confidence. Our platform ensures a smooth booking experience from start to finish.</p>
            </div>
            <div class="feature-item">
                <h3>Secure Payments</h3>
                <p>With our secure payment options, your transactions are safe and protected. Enjoy multiple payment methods for your convenience.</p>
            </div>
        </div>
    </div>

    <div class="section">
        <h2>Why Choose Invision?</h2>
        <p>Invision offers a unique combination of features that cater to both hotel owners and customers. Our platform is designed with cutting-edge technology to ensure a seamless experience, from managing your hotel to finding and booking the perfect stay.</p>
        <p>Join us today and discover how Invision can help elevate your hospitality business or make your next travel experience unforgettable.</p>
    </div>

    <div class="cta-section">
        <h2>Get Started with Invision Today</h2>
        <a href="{{ route('register') }}" class="button">Sign Up Now</a>
    </div>
@endsection

@section('pusherscript')
@endsection
